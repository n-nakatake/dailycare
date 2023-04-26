@extends('layouts.admin')
@section('title', 'ユーザー登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        ユーザーの登録に失敗しました。
                    </div> 
                @endif
                <h2>ユーザー登録</h2>
                <form class="mt-5" action="{{ route('admin.user.create') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">氏名 <span class="half-size">※</span></label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="性">
                            @if ($errors->has('last_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('last_name')}}</strong>
                                </span>
                            @endif                         
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="名">
                            @if ($errors->has('first_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('first_name')}}</strong>
                                </span>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">ユーザーID <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="user_code" value="{{ old('user_code') }}">
                            @if ($errors->has('user_code'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('user_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                        
                    <div class="form-group row">
                        <label class="col-md-3">資格 <span class="half-size">※</span></label>
                        <div class="col-md-4">
                            <select  class="form-control" name="qualification">
                                <option value="">選択してください</option>
                                @foreach ($qualifications as $key => $qualification)
                                    <option value="{{ $key }}" {{ old('qualification') === "$key" ? 'selected' : ''}}>{{ $qualification }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('qualification'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('qualification')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>    
                    <div class="form-group row">
                        <label class="col-md-3">パスワード <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="password" class="form-control" name="password" autocomplete="new-password">
                            @if ($errors->has('password'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                        
                    <div class="form-group row">
                        <label class="col-md-3">パスワード（確認） <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">管理者権限</label>
                        <div class="checkbox col-md-6">
                            <label>
                                <input type="checkbox" name="admin_flag" {{ old('admin_flag') ? 'checked' : '' }}> 管理者として登録する
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class=offset-md-3><span class="half-size">※</span>入力必須</label>
                    </div>  
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.user.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection