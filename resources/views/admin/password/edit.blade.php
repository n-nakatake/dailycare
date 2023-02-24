@extends('layouts.admin')
@section('title', 'パスワード変更')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        パスワードの変更に失敗しました。
                    </div> 
                @endif
                <h2>パスワード変更</h2>
                <form class="mt-5" action="{{ route('admin.password.update') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">現在のパスワード</label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" name="current_password">
                        </div>
                        @if ($errors->has('current_password'))
                            <span class="small text-danger offset-md-3 mt-1"><strong>{{ $errors->first('current_password') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">新しいパスワード</label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" name="password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="small text-danger offset-md-3 mt-1"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">新しいパスワード（確認）</label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ route('admin.top.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection