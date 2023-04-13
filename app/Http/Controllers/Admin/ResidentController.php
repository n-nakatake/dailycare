<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResidentRequest;
use App\Models\Resident;
use App\Models\CareLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ResidentController extends Controller
{
    public function add()
    {
        return view('admin.resident.create');
    }

    public function create(CreateResidentRequest $request)
    {
        // Validationを行う
        $resident = new Resident;
        $careLevel = new CareLevel;
        $form = $request->all();
        $form['office_id'] = Auth::user()->office_id;
    
        $careLevel->level = $form['level'];
        $careLevel->start_date = $form['level_start_date'];
        $careLevel->end_date = $form['level_end_date'];
        
         // formに画像があれば、保存する
        if (isset($form['image'])) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $resident->image_path = Storage::disk('s3')->url($path);
        } else {
            $resident->image_path = null;
        }
        
        // 不要な値を削除する
        unset(
            $form['_token'],
            $form['image'],
            $form['level'],
            $form['level_start_date'],
            $form['level_end_date']
        );

        // データベースに保存する
        $resident->fill($form);
        DB::transaction(function () use($resident, $careLevel) {
            $resident->save();
            $careLevel->resident_id = $resident->id;
            $careLevel->save();
        });

        $message = $form['last_name'] . $form['first_name'] . 'さんの利用者情報を登録しました。';

        return redirect(route('admin.resident.index'))
            ->with('message', $message);
    }


    public function index(Request $request)
    {
        $residents = Resident::where('office_id', Auth::user()->office_id)
            ->orderBy('last_name_k')
            ->orderBy('first_name_K')
            ->get();
        
        return view('admin.resident.index', ['residents' => $residents, 'careLevels' => CareLevel::LEVELS]);
    }

    public function edit(Request $request)
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.resident.edit')) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;

        // Resident Modelからデータを取得する
        $resident = Resident::find($request->id);
        if (empty($resident)) {
            abort(404);    
        }
        return view('admin.resident.edit', ['residentForm' => $resident]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Resident::$rules);
        // Resident Modelからデータを取得する
        $resident = Resident::find($request->id);
        // 送信されてきたフォームデータを格納する
        $resident_form = $request->all();
       
        if ($request->remove == 'true') {
           $form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $resident->image_path = Storage::disk('s3')->url($path);

        } else {
            $form['image_path'] = $resident->image_path;
        }
        
        unset($form['image']);
        unset($resident_form['remove']);
        unset($resident_form['_token']);
        
        // 該当するデータを上書きして保存する
        $resident->fill($resident_form)->save();

        // プロフィール履歴テーブルにデータを保存
        $residenthistory = new ResidentHistory();
        $residenthistory->resident_id = $resident->id;
        $residenthistory->edited_at = Carbon::now();
        $residenthistory->save();

        return redirect(session()->pull('fromUrl', route('admin.resident.index')))
            ->with('message', $message);
    }
    
  public function delete(Request $request)
  {

        // 該当するResident Modelを取得
        $resident = resident::find($request->id);

        $message = ($resident->last_name) . ($resident->first_name) . 'さんの入居者情報を削除しました。';
        // 削除する
        $resident->delete();

        return redirect(session()->pull('fromUrl', route('admin.resident.index')))
            ->with('message', $message);
    }
  
}