<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Excretion;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExcretionController extends Controller
{
    public function add(int $residentId)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または登録後にリダイレクトするURLをセッションに保存
        $previousUrl = url()->previous();
        $urlWithoutGetParameter = strpos($previousUrl, "?") === false ? $previousUrl : substr($previousUrl , 0 , strpos($previousUrl, "?"));
        if ($urlWithoutGetParameter !== route('admin.excretion.add', ['residentId' => $residentId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;

        return view('admin.excretion.create', [
            'users' => User::exist()->get(),
            'residents' => Resident::exist()->get(), 
            'residentId' => $residentId,
        ]);
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, excretion::$rules);
        $excretion = new excretion;
        $form = $request->all();
        $form['excretion_time'] = $form['excretion_date'] . ' ' . $form['excretion_time'];
        $form['office_id'] = Auth::user()->office_id;

        // 不要な値を削除する
        unset($form['excretion_date']);
        unset($form['_token']);

        if( isset($form['excretion_flash'] )){
            if( $form['excretion_flash'] ){
                $form['excretion_flash'] = 1;
            }else{
                $form['excretion_flash'] = 0;
            }
        }else{
            $form['excretion_flash'] = 0;
        }
        if( isset($form['excretion_dump'] )){
            if( $form['excretion_dump'] ){
                $form['excretion_dump'] = 1;
            }else{
                $form['excretion_dump'] = 0;
            }
        }else{
            $form['excretion_dump'] = 0;
        }
        // データベースに保存する
        $excretion->fill($form);
        $excretion->save();

        $excretionYm = substr($form['excretion_time'], 0, 7);
        $message = formatDatetime($form['excretion_time']) . 'の排泄状況を登録しました。';

        return redirect(session()->pull('fromUrl', route('admin.excretion.index', ['residentId' => $request->resident_id, 'excretion_ym' => $excretionYm])))
            ->with('message', $message);
    }
    
    public function index(Request $request, $residentId)
    {
        $requestDate = $request->excretion_ym;
        $dateYm = checkdate((int) substr($requestDate, 5, 2), 1, (int) substr($requestDate, 0, 4)) ? $request->excretion_ym : date('Y-m');

        $splitedDate = explode("-", $dateYm);
        $year = $splitedDate[0];
        $month = $splitedDate[1];
        $lastDay = Carbon::create($year, $month, 1)->lastOfMonth()->day;
        // 検索されたら検索結果を取得する
        $excretions = excretion::where('office_id', Auth::user()->office_id)
            ->where('resident_id', $residentId)
            ->whereBetween('excretion_time', [
                $year . '-' . $month . '-01 00:00:00',
                $year . '-' . $month . '-' . $lastDay . ' 23:59:59'
            ])
            ->orderBy('excretion_time', 'desc')
            ->get();

        $excretionsByDay = [];
        if ($excretions->isNotEmpty()){
            foreach($excretions as $excretion){
                $excretionDate = substr($excretion->excretion_time, 0, 10);
                $excretionsByDay[$excretionDate][] = $excretion;
            }
        }

        return view('admin.excretion.index', [
            'excretions' => $excretionsByDay,
            'dateYm' => $dateYm,
            'residents' => Resident::exist()->get(), 
            'residentId' => $residentId,
            'datesOfMonth' => $this->getAllDates($dateYm, $lastDay),
        ]);
    }
    
    public function edit(Request $request, $residentId, $excretionId)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.excretion.edit', ['residentId' => $residentId, 'excretionId' => $excretionId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;
        // excretion Modelからデータを取得する
        $excretion = excretion::where('office_id', $officeId)->where('id', $excretionId)->first();
        if (empty($excretion)) {
            abort(404);
        }

        return view('admin.excretion.edit', [
            'excretionForm' => $excretion,
            'users' => User::exist()->get(),
        ]);
    }

    public function update(Request $request, $residentId, $excretionId)
    {
        $this->validate($request, excretion::$rules);
        $excretion = $this->getValidexcretion($residentId, $excretionId);
        $form = $request->all();
        $form['excretion_time'] = $form['excretion_date'] . ' ' . $form['excretion_time'];

        // 不要な値を削除する
        unset($form['excretion_date']);
        unset($form['_token']);

        if( isset($form['excretion_flash'] )){
            if( $form['excretion_flash'] ){
                $form['excretion_flash'] = 1;
            }else{
                $form['excretion_flash'] = 0;
            }
        }else{
            $form['excretion_flash'] = 0;
        }
        if( isset($form['excretion_dump'] )){
            if( $form['excretion_dump'] ){
                $form['excretion_dump'] = 1;
            }else{
                $form['excretion_dump'] = 0;
            }
        }else{
            $form['excretion_dump'] = 0;
        }

        // 該当するデータを上書きして保存する
        $excretion->fill($form)->save();
        $excretionYm = substr($form['excretion_time'], 0, 7);
        $message = formatDatetime($form['excretion_time']) . 'の排泄状況を更新しました。';

        return redirect(session()->pull('fromUrl', route('admin.excretion.index', ['residentId' => $residentId, 'excretion_ym' => $excretionYm])))
            ->with('message', $message);
    }

    public function delete(Request $request, $residentId, $excretionId)
    {
        // 該当するexcretion Modelを取得
        $excretion = $this->getValidexcretion($residentId, $excretionId);
        $excretionYm = substr($excretion->excretion_time, 0, 7);
        $message = formatDatetime($excretion->excretion_time) . 'の排泄状況を削除しました。';
        $excretion->delete();

        return redirect(session()->pull('fromUrl', route('admin.excretion.index', ['residentId' => $residentId, 'excretion_ym' => $excretionYm])))
            ->with('message', $message);
    }

    private function getValidexcretion(int $residentId, int $excretionId)
    {
        $excretion = excretion::where('resident_id', $residentId)
            ->where('office_id', Auth::user()->office_id)
            ->where('id', $excretionId)
            ->first();

        if (is_null($excretion)) {
            abort(404);
        }

        return $excretion;
    }
}

