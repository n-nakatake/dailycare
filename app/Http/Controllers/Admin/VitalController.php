<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\History;
use Carbon\Carbon;

class VitalController extends Controller
{
    public function add()
    {
        return view('admin.vital.create');
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Vital::$rules);
        $vital = new Vital;
        $form = $request->all();

        // フォームから画像が送信されてきたら、保存して、$vital->image_path に画像のパスを保存する
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $vital->image_path = basename($path);
        } else {
            $vital->image_path = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $vital->fill($form);
        $vital->save();

        return redirect('admin/vital/create');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたら検索結果を取得する
            $posts = Vital::where('title', $cond_title)->get();
        } else {
            // それ以外はすべてのvitalを取得する
            $posts = Vital::all();
        }
        return view('admin.vital.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }    
    
    public function edit(Request $request)
    {
        // Vital Modelからデータを取得する
        $vital = Vital::find($request->id);
        if (empty($vital)) {
            abort(404);
        }
        return view('admin.vital.edit', ['vital_form' => $vital]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Vital::$rules);
        // Vital Modelからデータを取得する
        $vital = Vital::find($request->id);
        // 送信されてきたフォームデータを格納する
        $vital_form = $request->all();

        if ($request->remove == 'true') {
            $vital_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $vital_form['image_path'] = basename($path);
        } else {
            $vital_form['image_path'] = $vital->image_path;
        }

        unset($vital_form['image']);
        unset($vital_form['remove']);
        unset($vital_form['_token']);

        // 該当するデータを上書きして保存する
        $vital->fill($vital_form)->save();

        // 以下を追記
        $history = new History();
        $history->vital_id = $vital->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/vital');
    }

    public function delete(Request $request)
    {
        // 該当するVital Modelを取得
        $vital = Vital::find($request->id);

        // 削除する
        $vital->delete();

        return redirect('admin/vital/');
    }
    
}