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
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または登録後にリダイレクトするURLをセッションに保存
        $previousUrl = url()->previous();
        $urlWithoutGetParameter = strpos($previousUrl, "?") === false ? $previousUrl : substr($previousUrl , 0 , strpos($previousUrl, "?"));
        if ($urlWithoutGetParameter !== route('admin.vital.add', ['residentId' => $residentId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;
        $users = User::where('office_id', $officeId)->orderBy('id')->get();

        return view('admin.vital.create', [
            'users' => $users, 
            'residents' => Resident::exist()->get(), 
            'residentId' => $residentId
        ]);
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, vital::$rules);
        $vital = new vital;
        $form = $request->all();
        $form['vital_time'] = $form['vital_date'] . ' ' . $form['vital_time'];
        $form['office_id'] = Auth::user()->office_id;

        // フォームから画像が送信されてきたら、保存して、$vital->image_path に画像のパスを保存する
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $vital->vital_image_path = basename($path);
        } else {
            $vital->vital_image_path = null;
        }

        // 不要な値を削除する
        unset($form['vital_date']);
        unset($form['_token']);

        // データベースに保存する
        $vital->fill($form);
        $vital->save();

        $vitalYm = substr($form['vital_time'], 0, 7);
        $message = formatDatetime($form['vital_time']) . 'のバイタルを登録しました。';

        return redirect(session()->pull('fromUrl', route('admin.vital.index', ['residentId' => $request->resident_id, 'vital_ym' => $vitalYm])))
            ->with('message', $message);
    }

    public function index(Request $request, $residentId)
    {
        $requestDate = $request->vital_ym;
        $dateYm = checkdate((int) substr($requestDate, 5, 2), 1, (int) substr($requestDate, 0, 4)) ? $request->vital_ym : date('Y-m');        

        $splitedDate = explode("-", $dateYm);
        $year = $splitedDate[0];
        $month = $splitedDate[1];
        $lastDay = Carbon::create($year, $month, 1)->lastOfMonth()->day;
        // 検索されたら検索結果を取得する
        $vitals = vital::where('office_id', Auth::user()->office_id)
            ->where('resident_id', $residentId)
            ->whereBetween('vital_time', [
                $year . '-' . $month . '-01 00:00:00',
                $year . '-' . $month . '-' . $lastDay . ' 23:59:59'
            ])
            ->orderBy('vital_time', 'desc')
            ->get();
        $vitalsByDay = [];
        if ($vitals->isNotEmpty()){
            foreach($vitals as $vital){
                $vitalDate = substr($vital->vital_time, 0, 10);
                $vitalsByDay[$vitalDate][] = $vital;
            }
        }

        return view('admin.vital.index', [
            'vitals' => $vitalsByDay, 
            'dateYm' => $dateYm,
            'residents' => Resident::exist()->get(), 
            'residentId' => $residentId, 
            'datesOfMonth' => $this->getAllDates($dateYm, $lastDay),]);
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
        $vital = $this->getValidVital($residentId, $vitalId);
        $form = $request->all();
        $form['vital_time'] = $form['vital_date'] . ' ' . $form['vital_time'];
        
        if ($request->remove == 'true') {
            $form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $form['image_path'] = basename($path);
        } else {
            $form['image_path'] = $vital->vital_image_path;
        }

        unset($form['image']);

        // 不要な値を削除する
        unset($form['vital_date']);
        unset($form['_token']);

        // 該当するデータを上書きして保存する
        $vital->fill($form)->save();
        $vitalYm = substr($form['vital_time'], 0, 7);
        $message = formatDatetime($form['vital_time']) . 'のバイタルを更新しました。';

        return redirect(session()->pull('fromUrl', route('admin.vital.index', ['residentId' => $residentId, 'vital_ym' => $vitalYm])))
            ->with('message', $message);        
    }

    public function delete(Request $request, $residentId, $vitalId)
    {
        // 該当するvital Modelを取得
        $vital = $this->getValidVital($residentId, $vitalId);
        $vitalYm = substr($vital->vital_time, 0, 7);
        $message = formatDatetime($vital->vital_time) . 'のバイタルを削除しました。';
        $vital->delete();

        return redirect(session()->pull('fromUrl', route('admin.vital.index', ['residentId' => $residentId, 'vital_ym' => $vitalYm])))
            ->with('message', $message);
    }
    
    private function getValidVital(int $residentId, int $vitalId)
    {
        $vital = Vital::where('resident_id', $residentId)
            ->where('office_id', Auth::user()->office_id)
            ->where('id', $vitalId)
            ->first();

        if (is_null($vital)) {
            abort(404);
        }
        
        return $vital;
    }
    
}