<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPasswordRequest;
use Illuminate\Support\Facades\Auth;

class EditPasswordController extends Controller
{
    public function edit()
    {
        return view('admin.password.edit');
    }
    
    public function update(EditPasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect(route('admin.top.index'))
            ->with('message', 'パスワードを変更しました。');
    }
    
}
