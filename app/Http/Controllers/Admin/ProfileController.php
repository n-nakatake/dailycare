<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ProfileHistory;
use Illuminate\Http\Request;
use App\Models\Profile;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, Profile::$rules);
        $profile = new Profile;
        $form = $request->all();

         // formに画像があれば、保存する
        if (isset($form['image'])) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $profile->image_path = Storage::disk('s3')->url($path);
        } else {
            $profile->image_path = null;
        }
      
        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        unset($form['image']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile/create');
    }


    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $profiles = Profile::where('resident_last_name', $cond_name)->get();
        } else {
            $profiles = Profile::all();
        }
        return view('admin.profile.index', ['profiles' => $profiles, 'cond_name' => $cond_name]);
    }

    public function edit(Request $request)
    {
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);    
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profile::$rules);
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();
       
        if ($request->remove == 'true') {
           $form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
            $profile->image_path = Storage::disk('s3')->url($path);

        } else {
            $form['image_path'] = $profile->image_path;
        }
        
        unset($form['image']);
        unset($profile_form['remove']);
        unset($profile_form['_token']);
        
        // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();

        // プロフィール履歴テーブルにデータを保存
        $profilehistory = new ProfileHistory();
        $profilehistory->profile_id = $profile->id;
        $profilehistory->edited_at = Carbon::now();
        $profilehistory->save();
        

        return redirect('admin/profile/edit?id='. $request->id);
        //return redirect('admin/profile');
        
        
    }
    
  public function delete(Request $request)
  {
      // 該当するProfile Modelを取得
      $profile = profile::find($request->id);
      // 削除する
      $profile->delete();
      return redirect('admin/profile/');
  } 
    
}
