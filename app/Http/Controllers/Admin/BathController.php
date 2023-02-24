<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BathHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bath;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BathController extends Controller
{
    public function add(int $residentId)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または登録後にリダイレクトするURLをセッションに保存
        $previousUrl = url()->previous();
        $urlWithoutGetParameter = strpos($previousUrl, "?") === false ? $previousUrl : substr($previousUrl , 0 , strpos($previousUrl, "?"));
        if ($urlWithoutGetParameter !== route('admin.bath.add', ['residentId' => $residentId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;
        $users = User::where('office_id', $officeId)->orderBy('id')->get();
        $residents = Resident::where('office_id', $officeId)
            ->orderBy('last_name_k')
            ->orderBy('first_name_k')
            ->get();

        return view('admin.bath.create', [
            'users' => $users,
            'residents' => $residents,
            'residentId' => $residentId,
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
        $form['office_id'] = Auth::user()->office_id;

        // 不要な値を削除する
        unset($form['bath_date']);
        unset($form['_token']);

        // データベースに保存する
        $bath->fill($form);
        $bath->save();

        $bathYm = substr($form['bath_time'], 0, 7);
        $message = formatDatetime($form['bath_time']) . 'の入浴状況を登録しました。';

        return redirect(session()->pull('fromUrl', route('admin.bath.index', ['residentId' => $request->resident_id, 'bath_ym' => $bathYm])))
            ->with('message', $message);
    }
    
    public function index(Request $request, $residentId)
    {
        $officeId = Auth::user()->office_id;
        $residents = Resident::where('office_id', $officeId)
            ->orderBy('last_name_k')
            ->orderBy('first_name_k')
            ->get();

        $requestDate = $request->bath_ym;
        $dateYm = checkdate((int) substr($requestDate, 5, 2), 1, (int) substr($requestDate, 0, 4)) ? $request->bath_ym : date('Y-m');

        $splitedDate = explode("-", $dateYm);
        $year = $splitedDate[0];
        $month = $splitedDate[1];
        $lastDay = Carbon::create($year, $month, 1)->lastOfMonth()->day;
        // 検索されたら検索結果を取得する
        $baths = Bath::where('office_id', $officeId)
            ->where('resident_id', $residentId)
            ->whereBetween('bath_time', [
                $year . '-' . $month . '-01 00:00:00',
                $year . '-' . $month . '-' . $lastDay . ' 23:59:59'
            ])
            ->orderBy('bath_time', 'desc')
            ->get();
        $bathsByDay = [];
        if ($baths->isNotEmpty()){
            foreach($baths as $bath){
                $bathDate = substr($bath->bath_time, 0, 10);
                $bathsByDay[$bathDate][] = $bath;
            }
        }

        return view('admin.bath.index', [
            'baths' => $bathsByDay,
            'dateYm' => $dateYm,
            'residents' => $residents,
            'residentId' => $residentId,
            'datesOfMonth' => $this->getAllDates($dateYm, $lastDay),
        ]);
    }
    
    public function edit(Request $request, $residentId, $bathId)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.bath.edit', ['residentId' => $residentId, 'bathId' => $bathId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;
        $users = User::where('office_id', $officeId)->orderBy('id')->get();
        // bath Modelからデータを取得する
        $bath = Bath::where('office_id', $officeId)->where('id', $bathId)->first();
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
        $this->validate($request, Bath::$rules);
        $bath = Bath::find($bathId);
        $form = $request->all();
        $form['bath_time'] = $form['bath_date'] . ' ' . $form['bath_time'];

        // 不要な値を削除する
        unset($form['bath_date']);
        unset($form['_token']);

        // 該当するデータを上書きして保存する
        $bath->fill($form)->save();
        $bathYm = substr($form['bath_time'], 0, 7);
        $message = formatDatetime($form['bath_time']) . 'の入浴状況を更新しました。';

        return redirect(session()->pull('fromUrl', route('admin.bath.index', ['residentId' => $residentId, 'bath_ym' => $bathYm])))
            ->with('message', $message);
    }

    public function delete(Request $request, $residentId, $bathId)
    {
        // 該当するBath Modelを取得
        $bath = bath::find($bathId);
        $bathYm = substr($bath->bath_time, 0, 7);
        $message = formatDatetime($bath->bath_time) . 'の入浴状況を削除しました。';
        $bath->delete();

        return redirect(session()->pull('fromUrl', route('admin.bath.index', ['residentId' => $residentId, 'bath_ym' => $bathYm])))
            ->with('message', $message);
    }
}
