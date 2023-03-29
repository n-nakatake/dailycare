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
                        <label class="w-10rem">氏名</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('last_name')}}</strong>
                                </span>
                            @endif                         
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                            @if ($errors->has('first_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('first_name')}}</strong>
                                </span>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="w-10rem">資格</label>
                        <div class="col-md-2">
                            <select  class="form-control" name="qualification">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('qualification') === '1' ? 'selected' : ''}}>介護福祉士</option>
                                <option value="2" {{ old('qualification') === '2' ? 'selected' : ''}}>初任者研修修了</option>
                                <option value="3" {{ old('qualification') === '3' ? 'selected' : ''}}>ヘルパー2級</option>
                                <option value="4" {{ old('qualification') === '4' ? 'selected' : ''}}>ヘルパー1級</option>
                                <option value="5" {{ old('qualification') === '5' ? 'selected' : ''}}>介護支援専門員</option>
                                <option value="6" {{ old('qualification') === '6' ? 'selected' : ''}}>なし</option>
                            </select>
                            @if ($errors->has('qualification'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('qualification')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>    

                    <div class="form-group row">
                        <label class="w-10rem">ユーザーID</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="user_code" value="{{ old('user_code') }}">
                            @if ($errors->has('user_code'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('user_code')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                        

                    <div class="form-group row">
                        <label class="w-10rem">パスワード</label>
                        <div class="col-md-2">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @if ($errors->has('password'))
                                <span class="small text-danger error-left">
                                    <strong>{{$errors->first('password')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>   

                    <div class="form-group row">
                        <label class="w-10rem">パスワード（確認）</label>
                        <div class="col-md-2">
                            <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="w-10rem">退職日</label>
                        <div class="col-md-2">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="retirement_day" value="{{ old('retirement_day') }}">
                        </div>
                        @if ($errors->has('retirement_day'))
                            <span class="small text-danger error-left">
                                <strong>{{$errors->first('retirement_day')}}</strong>
                            </span>
                        @endif
                        </div>

                        <div class="checkbox" "col-md-2">
                            <label>
                                <input type="checkbox" name="retirement_flag" {{ old('retirement_flag') ? 'checked' : '' }}> 退職
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="checkbox" "col-md-2">
                            <label>
                                <input type="checkbox" name="admin_flag" {{ old('admin_flag') ? 'checked' : '' }}> 管理者として登録
                            </label>
                        </div>
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