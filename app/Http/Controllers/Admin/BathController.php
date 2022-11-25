<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BathHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bath;
use Carbon\Carbon;

class BathController extends Controller
{
    //
    public function add(int $residentId))
    {
        $users = User::all();
        return view('admin.bath.create', ['users' => $users, 'residentId' => $residentId]);
    }

    public function create(Request $request, int $residentId)
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

        return redirect('admin/bath/create');
    }

    public function edit(Request $request, $residentId)
    {
        // Bath Modelからデータを取得する
        $bath = Bath::find($request->id);
        if (empty($bath)) {
            abort(404);    
        }
        return view('admin.bath.edit', ['bath_form' => $bath]);    }

    public function update(Request $request, $residentId)
    {
        // Validationをかける
        $this->validate($request, Bath::$rules);
        // Profile Modelからデータを取得する
        $bath = Bath::find($request->id);
        // 送信されてきたフォームデータを格納する
        $bath_form = $request->all();

        unset($bath_form['remove']);
        unset($bath_form['_token']);
        
        // 該当するデータを上書きして保存する
        $bath->fill($bath_form)->save();

        // プロフィール履歴テーブルにデータを保存
        $bathhistory = new BathHistory();
        $bathhistory->bath_id = $bath->id;
        $bathhistory->edited_at = Carbon::now();
        $bathhistory->save();

        return redirect('admin/bath/edit?id='. $request->id);
    }
    
    public function index(Request $request, $residentId)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $baths = Bath::where('name', $cond_name)->get();
        } else {
            $baths = Bath::all();
        }
        return view('admin.bath.index', ['baths' => $baths, 'cond_name' => $cond_name]);
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
