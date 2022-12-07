@extends('layouts.admin')
@section('title', '入居者の新規登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>入居者プロフィール</h2>
                <form action="{{ route('admin.resident.create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2">氏名</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                        　　　　<p style="color: red;">{{$errors->first('last_name')}}</p>
                            @endif                        
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                            @if ($errors->has('first_name'))
                        　　　　<p style="color: red;">{{$errors->first('first_name')}}</p>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">氏名（フリガナ）</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="last_name_k" value="{{ old('last_name_k') }}">
                            @if ($errors->has('last_name_K'))
                        　　　　<p style="color: red;">{{$errors->first('last_name_K')}}</p>
                            @endif                        
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="first_name_K" value="{{ old('first_name_K') }}">
                            @if ($errors->has('first_name_k'))
                        　　　　<p style="color: red;">{{$errors->first('first_name_K')}}</p>
                            @endif                        
                        </div> 
                    </div>                    
                    
                    <div class="form-group row">
                        <label class="col-md-2">誕生日</label>
                        <div class="col-md-5">
                            <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}">
                            @if ($errors->has('birthday'))
                        　　　　<p style="color: red;">{{$errors->first('birthday')}}</p>
                            @endif                        
                        </div>

                        <label class="col-md-1">性別</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="gender">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('gender') === '1' ? 'selected' : ''}}>男性</option>
                                <option value="2" {{ old('gender') === '2' ? 'selected' : ''}}>女性</option>
                            </select>
                            @if ($errors->has('gender'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('gender')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">介護度</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="level">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('level') === '1' ? 'selected' : ''}}>要介護１</option>
                                <option value="2" {{ old('level') === '2' ? 'selected' : ''}}>要介護２</option>
                                <option value="3" {{ old('level') === '3' ? 'selected' : ''}}>要介護３</option>
                                <option value="4" {{ old('level') === '4' ? 'selected' : ''}}>要介護４</option>
                                <option value="5" {{ old('level') === '5' ? 'selected' : ''}}>要介護５</option>
                                <option value="6" {{ old('level') === '6' ? 'selected' : ''}}>要支援１</option>
                                <option value="7" {{ old('level') === '7' ? 'selected' : ''}}>要支援２</option>
                                <option value="8" {{ old('level') === '8' ? 'selected' : ''}}>該当なし</option>
                            </select>
                            @if ($errors->has('level'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('level')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                    </div>                          
                          
                    <div class="form-group row">
                        <label class="col-md-2">認定期間開始日</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="level_start" value="{{ old('level_start') }}">
                            @if ($errors->has('level_start'))
                        　　　　<p style="color: red;">{{$errors->first('level_start')}}</p>
                            @endif                        
                        </div>
                        <label class="col-md-2">認定期間終了日</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="level_end" value="{{ old('level_end') }}">
                            @if ($errors->has('level_end'))
                        　　　　<p style="color: red;">{{$errors->first('level_end')}}</p>
                            @endif                        
                        </div>
                    </div>    

                    <div class="form-group row">
                        <label class="col-md-2">キーパーソン名</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="key_person_name" value="{{ old('key_person_name') }}">
                            @if ($errors->has('key_person_name'))
                        　　　　<p style="color: red;">{{$errors->first('key_person_name')}}</p>
                            @endif                        
                        </div>
                        <label class="col-md-1">続柄</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_relation" value="{{ old('key_person_relation') }}">
                            @if ($errors->has('key_person_relation'))
                        　　　　<p style="color: red;">{{$errors->first('key_person_relation')}}</p>
                            @endif                        
                        </div>
                    </div>                        

                    <div class="form-group row">
                        <label class="col-md-2">キーパーソン住所</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="key_person_adress" value="{{ old('key_person_adress') }}">
                            <!--@if ($errors->has('key_person_adress'))-->
                        　　　　<!--<p style="color: red;">{{$errors->first('key_person_adress')}}</p>-->
                            <!--@endif                        -->
                        </div>
                    </div>           
                    
                    <div class="form-group row">
                        <label class="col-md-2">連絡先１</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_tel1" value="{{ old('key_person_tel1') }}">
                            <!--@if ($errors->has('key_person_tel1'))-->
                        　　　　<!--<p style="color: red;">{{$errors->first('key_person_tel1')}}</p>-->
                            <!--@endif                        -->
                        </div>
                        <label class="col-md-2">連絡先２</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_tel2" value="{{ old('key_person_tel2') }}">
                            <!--@if ($errors->has('key_person_tel2'))-->
                        　　　　<!--<p style="color: red;">{{$errors->first('key_person_tel2')}}</p>-->
                            <!--@endif                        -->
                        </div>
                    </div>      


                    <div class="form-group row">
                        <label class="col-md-2">メールアドレス</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" name="key_person_mail" value="{{ old('key_person_mail') }}">
                            <!--@if ($errors->has('key_person_mail'))-->
                        　　　　<!--<p style="color: red;">{{$errors->first('key_person_mail')}}</p>-->
                            <!--@endif                        -->
                        </div>
                    </div>   
                    
                    <div class="form-group row">
                        <label class="col-md-2">特記</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="note" rows="10">{{ old('note') }}</textarea>
                            <!--@if ($errors->has('note'))-->
                        　　　　<!--<p>{{$errors->first('note')}}</p>-->
                            <!--@endif   -->
                        </div>                        
                    </div>      
                    <div class="form-group row">
                        <label class="col-md-2" for="title">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>                    
                    @csrf
                    <div class="col-md-3 mx-auto">
                        <button class="btn btn-primary col-md-12" type="submit">登録</button>
                    </div>
                    <!--<input type="submit" class="col-md-4 btn btn-primary"  value="更新">-->

                </form>
            </div>
        </div>
    </div>




@endsection