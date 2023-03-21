@extends('layouts.admin')
@section('title', '入居者登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        入居者の登録に失敗しました。
                    </div> 
                @endif
                <h2>入居者登録</h2>
                <form class="mt-5" action="{{ route('admin.resident.create') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-8rem">氏名</label>
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
                        <label class="w-8rem">シメイ</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="last_name_k" value="{{ old('last_name_k') }}">
                            @if ($errors->has('last_name_k'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('last_name_k')}}</strong>
                                </span>
                            @endif                        
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="first_name_K" value="{{ old('first_name_K') }}">
                            @if ($errors->has('first_name_K'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('first_name_K')}}</strong>
                                </span>
                            @endif                        
                        </div> 
                    </div>

                    <div class="form-group row">
                        <label class="w-8rem">誕生日</label>
                        <div class="col-md-2">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="birthday" value="{{ old('birthday') }}">
                            @if ($errors->has('birthday'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('birthday')}}</strong>
                                </span>
                            @endif                        
                        </div>
                        <label class="w-5rem">性別</label>
                        <div class="col-md-2">
                            <select  class="form-control" name="gender">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('gender') === '1' ? 'selected' : ''}}>男性</option>
                                <option value="2" {{ old('gender') === '2' ? 'selected' : ''}}>女性</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('gender')}}</strong>
                                </span>
                            @endif                        
                        </div>
                    </div>                    

                    <div class="form-group row">
                        <label class="w-8rem">介護度</label>
                        <div class="col-md-2">
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
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('level')}}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="w-5rem">開始日</label>
                        <div class="col-md-2">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_start" value="{{ old('level_start') }}">
                            @if ($errors->has('level_start'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('level_start')}}</strong>
                                </span>
                            @endif  
                        </div>
                        <label class="w-5rem">終了日</label>
                        <div class="col-md-2">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_end" value="{{ old('level_end') }}">
                            @if ($errors->has('level_end'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('level_end')}}</strong>
                                </span>
                            @endif                        
                        </div>
                    </div>    

                    <div class="form-group row">
                        <label class="w-8rem">ｷｰﾊﾟｰｿﾝ名</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="key_person_name" value="{{ old('key_person_name') }}">
                            @if ($errors->has('key_person_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('key_person_name')}}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="w-5rem">続柄</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="key_person_relation" value="{{ old('key_person_relation') }}">
                            @if ($errors->has('key_person_relation'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('key_person_relation')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                        

                    <div class="form-group row">
                        <label class="w-8rem">ｷｰﾊﾟｰｿﾝ住所</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="key_person_adress" value="{{ old('key_person_adress') }}">
                        </div>
                    </div>           
                    
                    <div class="form-group row">
                        <label class="w-8rem">連絡先１</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_tel1" value="{{ old('key_person_tel1') }}">
                        </div>
                        <label class="w-6rem">連絡先２</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_tel2" value="{{ old('key_person_tel2') }}">
                        </div>
                    </div>      


                    <div class="form-group row">
                        <label class=w-8rem>メールアドレス</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="key_person_mail" value="{{ old('key_person_mail') }}">
                        </div>
                    </div>   
                    
                    <div class="form-group row">
                        <label class=w-8rem>特記</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="note" rows="10">{{ old('note') }}</textarea>
                        </div>                        
                    </div>      
                    <div class="form-group row">
                        <label class=w-8rem for="title">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>  
                    
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.resident.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection