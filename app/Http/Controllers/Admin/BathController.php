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
        
        return view('admin.bath.create', [
            'users' => $users,
            'residents' => $residents,
            'residentId' => $residentId,
            'residentName' => $residentName,
            'bathMethods' => Bath::BATH_METHODS,
        ]);
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Bath::$rules);
        $bath = new Bath;
        $form = $request->all();
        $form['bath_time'] = $form['bath_date'] . ' ' . $form['bath_time'];

        // 不要な値を削除する
        unset($form['bath_date']);
        unset($form['_token']);

        // データベースに保存する
        $bath->fill($form);
        $bath->save();

        return redirect(route('admin.bath.index', ['residentId' => $request->resident_id]))
            ->with('message', '入浴状況を登録しました。');
    }
    
    public function index(Request $request, $residentId)
    {
        $residents = Resident::all();
        $residentId = $request->resident_id ? (int)$request->resident_id : $residentId; 
        $residentName = $residents->where('id', $residentId)->first()->last_name . $residents->where('id', $residentId)->first()->first_name;
        
        $requestDate = $request->bath_ym;
        $date = checkdate((int) substr($requestDate, 5, 2), 1, (int) substr($requestDate, 0, 4)) ? $request->bath_ym : date('Y-m');
        $baths = [];

        $splitedDate = explode("-", $date);
        $year = $splitedDate[0];
        $month = $splitedDate[1];
        $lastDay = Carbon::create($year, $month, 1)->lastOfMonth()->day;
        // 検索されたら検索結果を取得する
        $baths = Bath::where('resident_id', $residentId)->whereBetween('bath_time', [
                $year . '-' . $month . '-01 00:00:00',
                $year . '-' . $month . '-' . $lastDay . ' 23:59:59'
            ])
            ->orderBy('bath_time')
            ->get();
        $bathsByDay = [];
        if ($baths !== []){
            foreach($baths as $bath){
                $bathDate = str_split($bath->bath_time, 10)[0];
                $bathsByDay[$bathDate][] = $bath;
            }
        }

        return view('admin.bath.index', [
            'baths' => $bathsByDay,
            'date' => $date,
            'residents' => $residents,
            'residentId' => $residentId,
        ]);
    }
    
    public function edit(Request $request, $residentId, $bathId)
    {
        $users = User::all();
        // bath Modelからデータを取得する
        $bath = Bath::find($bathId);
        if (empty($bath)) {
            abort(404);
        }

        return view('admin.bath.edit', [
            'bathForm' => $bath,
            'users' => $users,
            'bathMethods' => Bath::BATH_METHODS,
        ]);
    }

    public function update(Request $request, $residentId, $bathId)
    {
        // Validationをかける
        $this->validate($request, Bath::$rules);
        // Bath Modelからデータを取得する
        $bath = Bath::find($bathId);
        // 送信されてきたフォームデータを格納する
        $form = $request->all();
        $form['bath_time'] = $form['bath_date'] . ' ' . $form['bath_time'];

        // 不要な値を削除する
        unset($form['bath_date']);
        unset($form['_token']);

        // 該当するデータを上書きして保存する
        $bath->fill($form)->save();

        return redirect(route('admin.bath.index', ['residentId' => $residentId]))
            ->with('message', '入浴状況を更新しました。');
    }

    public function delete(Request $request, $residentId, $bathId)
    {
        // 該当するBath Modelを取得
        $bath = bath::find($bathId);
        $bath->delete();

        return redirect(route('admin.bath.index', ['residentId' => $residentId]))
            ->with('message', '入浴状況を削除しました。');
    }
}
