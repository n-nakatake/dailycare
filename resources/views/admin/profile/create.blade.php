@extends('layouts.admin')
@section('title', '入居者の新規登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>入居者プロフィール</h2>
                <form action="{{ route('admin.profile.create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2">名前</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                        　　　　<p style="color: red;">{{$errors->first('name')}}</p>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">性別</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="gender">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('gender') === '1' ? 'selected' : ''}}>男性</option>
                                <option value="2" {{ old('gender') === '2' ? 'selected' : ''}}>女性</option>
                                <option value="3" {{ old('gender') === '3' ? 'selected' : ''}}>回答しない</option>
                            </select>
                            @if ($errors->has('gender'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('gender')}}</strong>
                        　　　　</span>
                            @endif                        

                            <!--@if ($errors->has('email'))-->
                            <!--    <span class="invalid-feedback">-->
                            <!--        <strong>{{ $errors->first('email') }}</strong>-->
                            <!--    </span>-->
                            <!--@endif-->

                      
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">趣味</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="hobby" value="{{ old('hobby') }}">
                            @if ($errors->has('hobby'))
                        　　　　<p>{{$errors->first('hobby')}}</p>
                            @endif    
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="col-md-2">自己紹介</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="introduction" rows="10">{{ old('introduction') }}</textarea>
                            @if ($errors->has('introduction'))
                        　　　　<p>{{$errors->first('introduction')}}</p>
                            @endif   
                        </div>
                    </div>
                    @csrf
                    <div class="col-md-3 mx-auto">
                        <button class="btn btn-primary col-md-12" type="submit">更新</button>
                    </div>
                    <!--<input type="submit" class="col-md-4 btn btn-primary"  value="更新">-->

                </form>
            </div>
        </div>
    </div>




@endsection