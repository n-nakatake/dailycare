<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Excretion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
    public function add()
    {
        // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または登録後にリダイレクトするURLをセッションに保存
        $previousUrl = url()->previous();
        $urlWithoutGetParameter = strpos($previousUrl, "?") === false ? $previousUrl : substr($previousUrl , 0 , strpos($previousUrl, "?"));
        if ($urlWithoutGetParameter !== route('admin.user.add')) {
            session(['fromUrl' => url()->previous()]);
        }
        return view('admin.user.create');
    }

    public function create(Request $request)
    {
        // Validationを行う
        //dd($request);
        $this->validate($request, user::$rules);
        $user = new user;
        $form = $request->all();
        $form['office_id'] = Auth::user()->office_id;
        $form['email'] = $form['user_code'];
        $form['password'] = Hash::make($form['password']);
        $form['admin_flag'] = isset($form['admin_flag']) ? true : false;
        $form['retirement_flag'] = isset($form['retirement_flag']) ? true : false;
            
            
        // 不要な値を削除する
        unset($form['_token']);

        // データベースに保存する
        $user->fill($form);
        $user->save();

        $message = $form['last_name'] . 'さんの利用者情報を登録しました。';

        return redirect(session()->pull('fromUrl', route('admin.user.index')))
            ->with('message', $message);
    }


    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $users = user::where('office_id', Auth::user()->office_id)
                ->where('last_name', $cond_name)
                ->get();
        } else {
            $users = user::where('office_id', Auth::user()->office_id)
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get();
        }
        return view('admin.user.index', ['users' => $users, 'cond_name' => $cond_name]);
    }

    public function edit(Request $request, $userId)
    {
        //dd($userId);
         // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.user.edit', ['userId' => $userId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $officeId = Auth::user()->office_id;

        // user Modelからデータを取得する
        $user = user::find($userId);
        //dd($userId);
        if (empty($user)) {
            abort(404);    
        }
        
        return view('admin.user.edit', ['userForm' => $user,'userId' => $userId]);
        
    }

    public function update(UserRequest $request, $userId) // 河野 修正 UserRequestに修正
    {
        //dd($userId);
        //$user = $this->getValidUser($userId);
        // Validationをかける
        //$this->validate($request, User::$rules);
        // user Modelからデータを取得する
        $user = user::find($userId);
        // dd($user);



        // 送信されてきたフォームデータを格納する
        $user_form = $request->all();
       
        unset($user_form['remove']);
        unset($user_form['_token']);
        $user_form['admin_flag'] = isset($user_form['admin_flag']) ? true : false; // 河野 修正 admin_flagに対してonという文字列がセットされていて、それがエラーを起こしていたため
        // 該当するデータを上書きして保存する
        $user->fill($user_form)->save();

        $message = $user_form['last_name'] . $user_form['first_name'] . 'さんのユーザー情報を更新しました。';

        return redirect(session()->pull('fromUrl', route('admin.user.index')))
            ->with('message', $message);
    }
  
  public function delete(Request $request)
  {
        // 該当するuser Modelを取得
        $user = user::find($request->id);

        $message = ($user->last_name) . ($user->first_name) . 'さんのユーザー情報を削除しました。';
        // 削除する
        $user->delete();

        return redirect(session()->pull('fromUrl', route('admin.user.index')))
            ->with('message', $message);
    }

 }
