<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vital;
use App\Models\History;
use App\Models\User;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        return view('admin.vital.create', [
            'users' => User::exist()->get(),
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

        // formに画像があれば、保存する
        if ($request->file('image')) {
            $officeId = Auth::user()->office_id;
            $imagePath = $request->file('image')->store("protected/$officeId/vitals");
            $vital->vital_image_path = $imagePath;
        }

        // 不要な値を削除する
        unset($form['vital_date']);
        unset($form['image']);
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
            'datesOfMonth' => $this->getAllDates($dateYm, $lastDay),
        ]);
    }    
    
    public function edit(Request $request, $residentId, $vitalId)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または登録後にリダイレクトするURLをセッションに保存
        $previousUrl = url()->previous();
        $urlWithoutGetParameter = strpos($previousUrl, "?") === false ? $previousUrl : substr($previousUrl , 0 , strpos($previousUrl, "?"));
        if ($urlWithoutGetParameter !== route('admin.vital.edit', ['residentId' => $residentId, 'vitalId' => $vitalId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $vital = $this->getValidVital($residentId, $vitalId);
        
        return view('admin.vital.edit', [
            'vitalForm' => $vital,
            'users' => User::exist()->get(),
        ]);
    }

    public function update(Request $request, $residentId, $vitalId)
    {
        
        $this->validate($request, Vital::$rules);
        $vital = $this->getValidVital($residentId, $vitalId);
        $form = $request->all();
        $form['vital_time'] = $form['vital_date'] . ' ' . $form['vital_time'];
        
        $deleteImagePath = '';
        if ($request->remove) {
            $deleteImagePath = $vital->vital_image_path;
            $vital->vital_image_path = null;
        }
        if ($request->file('image')) {
            $deleteImagePath = $vital->vital_image_path;
            $officeId = Auth::user()->office_id;
            $imagePath = $request->file('image')->store("protected/$officeId/vitals");
            $vital->vital_image_path = $imagePath;
        }

        // 不要な値を削除する
        unset($form['image']);
        unset($form['vital_date']);
        unset($form['_token']);

        // 該当するデータを上書きして保存する
        $vital->fill($form)->save();
        if (!empty($deleteImagePath)) {
            Storage::delete($deleteImagePath); //画像ファイルの削除
        }

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

        if ($vital->vital_image_path) {
            Storage::delete($vital->vital_image_path); //画像ファイルの削除
        }
        $vital->delete();
        $message = formatDatetime($vital->vital_time) . 'のバイタルを削除しました。';

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