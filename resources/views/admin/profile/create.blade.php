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
                        <label class="col-md-2">氏名</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="resident_last_name" value="{{ old('resident_last_name') }}">
                            @if ($errors->has('resident_last_name'))
                        　　　　<p style="color: red;">{{$errors->first('resident_last_name')}}</p>
                            @endif                        
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="resident_first_name" value="{{ old('resident_first_name') }}">
                            @if ($errors->has('resident_first_name'))
                        　　　　<p style="color: red;">{{$errors->first('resident_first_name')}}</p>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">氏名（フリガナ）</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="resident_last_name_k" value="{{ old('resident_last_name_k') }}">
                            @if ($errors->has('resident_last_name_K'))
                        　　　　<p style="color: red;">{{$errors->first('resident_last_name_K')}}</p>
                            @endif                        
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="resident_first_name_K" value="{{ old('resident_first_name_K') }}">
                            @if ($errors->has('resident_first_name_k'))
                        　　　　<p style="color: red;">{{$errors->first('resident_first_name_K')}}</p>
                            @endif                        
                        </div> 
                    </div>                    
                    
                    <div class="form-group row">
                        <label class="col-md-2">誕生日</label>
                        <div class="col-md-5">
                            <input type="date" class="form-control" name="resident_birthday" value="{{ old('resident_birthday') }}">
                            @if ($errors->has('resident_birthday'))
                        　　　　<p style="color: red;">{{$errors->first('resident_birthday')}}</p>
                            @endif                        
                        </div>

                        <label class="col-md-1">性別</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="resident_gender">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('resident_gender') === '1' ? 'selected' : ''}}>男性</option>
                                <option value="2" {{ old('resident_gender') === '2' ? 'selected' : ''}}>女性</option>
                            </select>
                            @if ($errors->has('resident_gender'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('resident_gender')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">介護度</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="resident_level">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('resident_level') === '1' ? 'selected' : ''}}>要介護１</option>
                                <option value="2" {{ old('resident_level') === '2' ? 'selected' : ''}}>要介護２</option>
                                <option value="3" {{ old('resident_level') === '3' ? 'selected' : ''}}>要介護３</option>
                                <option value="4" {{ old('resident_level') === '4' ? 'selected' : ''}}>要介護４</option>
                                <option value="5" {{ old('resident_level') === '5' ? 'selected' : ''}}>要介護５</option>
                                <option value="6" {{ old('resident_level') === '6' ? 'selected' : ''}}>要支援１</option>
                                <option value="7" {{ old('resident_level') === '7' ? 'selected' : ''}}>要支援２</option>
                                <option value="8" {{ old('resident_level') === '8' ? 'selected' : ''}}>該当なし</option>
                            </select>
                            @if ($errors->has('resident_level'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('resident_level')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                    </div>                          
                          
                    <div class="form-group row">
                        <label class="col-md-2">認定期間開始日</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="resident_level_start" value="{{ old('resident_level_start') }}">
                            @if ($errors->has('resident_level_start'))
                        　　　　<p style="color: red;">{{$errors->first('resident_level_start')}}</p>
                            @endif                        
                        </div>
                        <label class="col-md-2">認定期間終了日</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="resident_level_end" value="{{ old('resident_level_end') }}">
                            @if ($errors->has('resident_level_end'))
                        　　　　<p style="color: red;">{{$errors->first('resident_level_end')}}</p>
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
                            <textarea class="form-control" name="resident_note" rows="10">{{ old('resident_note') }}</textarea>
                            <!--@if ($errors->has('resident_note'))-->
                        　　　　<!--<p>{{$errors->first('resident_note')}}</p>-->
                            <!--@endif   -->
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