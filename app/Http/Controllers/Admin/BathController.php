<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BathHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bath;
use App\Models\Resident;
use Carbon\Carbon;

class BathController extends Controller
{
    public function add(int $residentId)
    {
        $users = User::all();
        $residents = Resident::all();
        $residentName = $residents->where('id', $residentId)->first()->last_name . $residents->where('id', $residentId)->first()->first_name;
        return view('admin.bath.create', ['users' => $users, 'residents' => $residents, 'residentId' => $residentId, 'residentName' => $residentName]);
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Bath::$rules);
        $bath = new Bath;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $bath->fill($form);
        $bath->save();

        return redirect('admin/bath/create/' . $request->resident_id);
    }

    public function edit(Request $request, $residentId, $vitalId)
    {
        $users = User::all();
        // bath Modelからデータを取得する
        $bath = Bath::find($request->bathId);
        if (empty($bath)) {
            abort(404);
        }
        return view('admin.bath.edit', ['bathForm' => $bath, 'users' => $users]);
    }

    
    public function index(Request $request, $residentId)
    {
        $residents = Resident::all();
        $residentId = $request->resident_id ? (int)$request->resident_id : $residentId; 
        $residentName = $residents->where('id', $residentId)->first()->last_name . $residents->where('id', $residentId)->first()->first_name;
        
        $date = $request->bath_ym;
        $baths = [];

        if ($date != '') {
            $splitedDate = explode("-", $date);
            $year = $splitedDate[0];
            $month = $splitedDate[1];
            $lastDay = Carbon::create($year, $month, 1)->lastOfMonth()->day;
            // 検索されたら検索結果を取得する
            $baths = Bath::where('resident_id', $residentId)->whereBetween('bath_time', [
                    $year . '-' . $month . '-01 00:00:00',
                    $year . '-' . $month . '-' . $lastDay . ' 23:59:59'
                ])->get();
        } else {
            // それ以外はすべてのbathを取得する
            $baths = Bath::where('resident_id', $residentId)->get();
        }
        $bathsByDay = [];
        if ($baths !== []){
            foreach($baths as $bath){
                $bathDate = str_split($bath->bath_time, 10)[0];
                $bathsByDay[$bathDate][] = $bath;
            }
        }

        return view('admin.bath.index', ['baths' => $bathsByDay, 'date' => $date, 'residents' => $residents, 'residentId' => $residentId, 'residentName' => $residentName]);    
        } 
    
    
    public function update(Request $request, $residentId, $bathId)
    {
        // Validationをかける
        $this->validate($request, Bath::$rules);
        // Bath Modelからデータを取得する
        $bath = Bath::find($bathId);
        // 送信されてきたフォームデータを格納する
        $bath_form = $request->all();

        if ($request->remove == 'true') {
            $bath_form['bath_image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $bath_form['bath_image_path'] = basename($path);
        } else {
            $bath_form['bath_image_path'] = $bath->bath_image_path;
        }

        unset($bath_form['image']);
        unset($bath_form['remove']);
        unset($bath_form['_token']);

        // 該当するデータを上書きして保存する
        $bath->fill($bath_form)->save();

        // 以下を追記
        $history = new History();
        $history->resident_id = $bath->resident_id;
        $history->bath_id = $bath->id;
        $history->edited_at = Carbon::now();
        $history->save();

//        return redirect('admin/bath/edit?id=' . $residentId);
        return redirect('admin/bath/' . $residentId);
    }
    
    
    public function delete(Request $request, $residentId)
    {
        // 該当するBath Modelを取得
        $bath = bath::find($request->id);
        // 削除する
        $bath->delete();
        return redirect('admin/bath/');
      }     
    
}
