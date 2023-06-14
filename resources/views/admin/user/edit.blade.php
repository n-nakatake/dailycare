@extends('layouts.admin')
@section('title', 'ユーザー情報の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        ユーザー情報の更新に失敗しました。
                    </div>
                @endif
                <h2>ユーザー情報の編集</h2>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $user->id }}">
                            削除
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ $user->last_name }}{{ $user->first_name }}さんのデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.user.delete', ['userId' => $user->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.user.update', ['userId' => $user->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">ユーザーID</span></label>
                        <div class="col-md-3">{{ $user->user_code }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">氏名 <span class="half-size">※</span></label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" autocomplete="off">
                        </div>
                        @if ($errors->has('last_name'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('first_name'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">資格</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="qualification">
                                @foreach ($qualifications as $key => $qualification)
                                    <option value="{{ $key }}" {{ old('qualification') ? (old('qualification') === "$key" ? 'selected' : '') : ($user->qualification === $key ? 'selected' : '') }}>{{ $qualification }}</option>
                                @endforeach
                            </select>
                        </div>                        
                        @if ($errors->has('qualification'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('qualification') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3"></label>
                        <div class="checkbox col-md-6">
                            <label>
                                <input type="checkbox" name="admin_flag" 
                                    @if (old('admin_flag') || (!old('admin_flag') && $user->admin_flag))
                                        checked
                                    @endif
                                >
                                管理者として登録
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class=offset-md-3><span class="half-size">※</span>入力必須</label>
                    </div>  
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.user.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection