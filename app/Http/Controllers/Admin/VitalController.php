<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\History;
use App\Models\User;
use App\Models\Resident;
use Carbon\Carbon;

class VitalController extends Controller
{
    public function add(int $residentId)
    {
        $users = User::all();
        $residents = Resident::all();
        $residentName = $residents->where('id', $residentId)->first()->last_name . $residents->where('id', $residentId)->first()->first_name;
        /*$filteredResidents = $residents->filter(function ($resident, $key) use($residentId) {
            return $resident->id !== $residentId;
        });*/
        return view('admin.vital.create', ['users' => $users, 'residents' => $residents, 'residentId' => $residentId, 'residentName' => $residentName]);
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Vital::$rules);
        $vital = new Vital;
        $form = $request->all();

        // フォームから画像が送信されてきたら、保存して、$vital->image_path に画像のパスを保存する
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $vital->vital_image_path = basename($path);
        } else {
            $vital->vital_image_path = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $vital->fill($form);
        $vital->save();

        return redirect('admin/vital/create/' . $request->resident_id);
    }

    public function index(Request $request, $residentId)
    {
        $residents = Resident::all();
        $residentName = $residents->where('id', $residentId)->first()->last_name . $residents->where('id', $residentId)->first()->first_name;
        
        $date = $request->date;
        $vitals = [];
        $date = '202211';
        if ($date != '') {
            $splitedDate = str_split($date, 4);
            $year = $splitedDate[0];
            $month = $splitedDate[1];
            $lastDay = Carbon::create($year, $month, 1)->lastOfMonth()->day;
            // 検索されたら検索結果を取得する
            $vitals = Vital::where('resident_id', $residentId)->whereBetween('vital_time', [
                    $year . '-' . $month . '-01 00:00:00',
                    $year . '-' . $month . '-' . $lastDay . ' 23:59:59'
                ])->get();
        } else {
            // それ以外はすべてのvitalを取得する
            $vitals = Vital::where('resident_id', $residentId)->get();
        }
        $vitalsByDay = [];
        if ($vitals !== []){
            foreach($vitals as $vital){
                $vitalDate = str_split($vital->vital_time, 10)[0];
                $vitalsByDay[$vitalDate][] = $vital;
            }
        }
        return view('admin.vital.index', ['vitals' => $vitalsByDay, 'date' => $date, 'residents' => $residents, 'residentId' => $residentId, 'residentName' => $residentName]);
    }    
    
    public function edit(Request $request, $residentId)
    {
        // Vital Modelからデータを取得する
        $vital = Vital::find($request->id);
        if (empty($vital)) {
            abort(404);
        }
        return view('admin.vital.edit', ['vital_form' => $vital]);
    }

    public function update(Request $request, $residentId)
    {
        // Validationをかける
        $this->validate($request, Vital::$rules);
        // Vital Modelからデータを取得する
        $vital = Vital::find($request->id);
        // 送信されてきたフォームデータを格納する
        $vital_form = $request->all();

        if ($request->remove == 'true') {
            $vital_form['vital_image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $vital_form['vital_image_path'] = basename($path);
        } else {
            $vital_form['vital_image_path'] = $vital->vital_image_path;
        }

        unset($vital_form['image']);
        unset($vital_form['remove']);
        unset($vital_form['_token']);

        // 該当するデータを上書きして保存する
        $vital->fill($vital_form)->save();

        // 以下を追記
        $history = new History();
        $history->vital_id = $vital->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/vital');
    }

    public function delete(Request $request, $residentId)
    {
        // 該当するVital Modelを取得
        $vital = Vital::find($request->id);

        // 削除する
        $vital->delete();

        return redirect('admin/vital/');
    }
    
}