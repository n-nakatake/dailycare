<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ResidentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Resident;
use Carbon\Carbon;

class ResidentController extends Controller
{
    public function add()
    {
        return view('admin.resident.create');
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Resident::$rules);
        $resident = new Resident;
        $form = $request->all();
        $form['office_id'] = Auth::user()->office_id;

         // formに画像があれば、保存する
        if (isset($form['image'])) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $resident->image_path = Storage::disk('s3')->url($path);
        } else {
            $resident->image_path = null;
        }
      
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        unset($form['image']);

        // データベースに保存する
        $resident->fill($form);
        $resident->save();

        return redirect('admin/resident/create');
    }


    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $residents = Resident::where('office_id', Auth::user()->office_id)
                ->where('last_name', $cond_name)
                ->get();
        } else {
            $residents = Resident::where('office_id', Auth::user()->office_id)
                ->orderBy('last_name_k')
                ->orderBy('first_name_K')
                ->get();
        }
        return view('admin.resident.index', ['residents' => $residents, 'cond_name' => $cond_name]);
    }

    public function edit(Request $request)
    {
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

        return redirect('admin/resident/edit?id='. $request->id);
    }
    
  public function delete(Request $request)
  {
      // 該当するResident Modelを取得
      $resident = resident::find($request->id);
      // 削除する
      $resident->delete();
      return redirect('admin/resident/');
  } 
}
