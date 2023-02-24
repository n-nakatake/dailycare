<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\History;
use App\Models\User;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VitalController extends Controller
{
    public function add(int $residentId)
    {
        $users = User::where('office_id', Auth::user()->office_id)->orderBy('id')->get();
        $residents = Resident::where('office_id', Auth::user()->office_id)
            ->orderBy('last_name_k')
            ->orderBy('first_name_k')
            ->get();
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
        $form['office_id'] = Auth::user()->office_id;

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
        $residents = Resident::where('office_id', Auth::user()->office_id)
            ->orderBy('last_name_k')
            ->orderBy('first_name_k')
            ->get();
        $residentId = $request->resident_id ? (int)$request->resident_id : $residentId; 
        $residentName = $residents->where('id', $residentId)->first()->last_name . $residents->where('id', $residentId)->first()->first_name;
        $date = $request->vital_ym;
        $vitals = [];

        if ($date != '') {
            $splitedDate = explode("-", $date);
            //$splitedDate = str_split($date, 4);
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
    
    public function edit(Request $request, $residentId, $vitalId)
    {
        $users = User::where('office_id', Auth::user()->office_id)->orderBy('id')->get();
        $vital = Vital::find($request->vitalId);
        if (empty($vital)) {
            abort(404);
        }
        return view('admin.vital.edit', ['vitalForm' => $vital, 'users' => $users]);
    }

    public function update(Request $request, $residentId, $vitalId)
    {
        $this->validate($request, Vital::$rules);
        $vital = Vital::find($vitalId);
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
        $history->resident_id = $vital->resident_id;
        $history->vital_id = $vital->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/vital/' . $residentId);
    }

    public function delete(Request $request, $residentId)
    {
        $vital = Vital::find($request->id);
        $vital->delete();

        return redirect('admin/vital/');
    }
    
}