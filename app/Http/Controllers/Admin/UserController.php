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
use App\Http\Requests\RetireUserRequest;
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
        return view('admin.user.create', ['qualifications' => User::QUALIFICATIONS]);
    }

    public function create(Request $request)
    {
        // Validationを行う
        $this->validate($request, User::$rules);
        $user = new user;
        $form = $request->all();
        $form['office_id'] = Auth::user()->office_id;
        $form['email'] = $form['user_code']; // user_codeでログインさせるためemailに同じ値をセットしている
        $form['password'] = Hash::make($form['password']);
        $form['admin_flag'] = isset($form['admin_flag']) ? true : false;

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
        return view('admin.user.index', [
            'users' => User::exist()->get(),
            'qualifications' => User::QUALIFICATIONS,
        ]);
    }

    public function edit(Request $request, int $userId)
    {
         // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.user.edit', ['userId' => $userId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $user = $this->getValidUser($userId);
        
        return view('admin.user.edit', [
            'user' => $user,
            'qualifications' => User::QUALIFICATIONS,
        ]);
        
    }

    public function update(UserRequest $request, int $userId)
    {
        $user = $this->getValidUser($userId);
        $form = $request->all();
       
        unset($form['remove']);
        unset($form['_token']);
        $form['admin_flag'] = isset($form['admin_flag']) ? true : false;
        
        $user->fill($form)->save();

        $message = $form['last_name'] . $form['first_name'] . 'さんのユーザー情報を更新しました。';

        return redirect(session()->pull('fromUrl', route('admin.user.index')))
            ->with('message', $message);
    }
  
  public function retiring(Request $request, int $userId)
  {
         // バリデーションエラー以外で遷移してきたら、キャンセルボタン押下時または更新後にリダイレクトするURLをセッションに保存
        if (url()->previous() !== route('admin.user.retire', ['userId' => $userId])) {
            session(['fromUrl' => url()->previous()]);
        }

        $user = $this->getValidUser($userId);

        return view('admin.user.retire', ['user' => $user]);
    }
  
  public function retire(RetireUserRequest $request, int $userId)
  {
        $user = $this->getValidUser($userId);
        $form = $request->all();
        $form['retirement_date'] = $form['retirement_date'] . ' 23:59:59'; // 退職日の終わりまでは在籍しているようにする
        unset($form['_token']);
        $user->fill($form);
        $user->save();

        $message = ($user->last_name) . ($user->first_name) . 'さんの退職情報を登録しました。';

        return redirect(route('admin.user.index'))->with('message', $message);
    }
  
  public function delete(Request $request, int $userId)
  {
        $user = $this->getValidUser($userId);

        $user->delete();
        $message = ($user->last_name) . ($user->first_name) . 'さんのユーザー情報を削除しました。';

        return redirect(session()->pull('fromUrl', route('admin.user.index')))
            ->with('message', $message);
    }
     
    private function getValidUser(int $userId)
    {
        $user = User::where('office_id', Auth::user()->office_id)
            ->where('id', $userId)
            ->first();

        if (is_null($user)) {
            abort(404);
        }
        
        return $user;
    }
}
