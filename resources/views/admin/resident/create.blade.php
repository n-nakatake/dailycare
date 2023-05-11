@extends('layouts.admin')
@section('title', '入居者の登録')

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
                <h2>入居者の登録</h2>
                <form class="mt-5" action="{{ route('admin.resident.create') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">氏名 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="性" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="名" autocomplete="off">
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
                        <label class="col-md-3">氏名（カナ） <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="last_name_k" value="{{ old('last_name_k') }}" placeholder="セイ" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="first_name_k" value="{{ old('first_name_k') }}" placeholder="メイ" autocomplete="off">
                        </div> 
                        @if ($errors->has('last_name_k'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('last_name_k') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('first_name_k'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('first_name_k') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">誕生日 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="birthday" value="{{ old('birthday') }}">
                        </div>
                        @if ($errors->has('birthday'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>                    
                    <div class="form-group row">
                        <label class="col-md-3">性別 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <select  class="form-control" name="gender">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('gender') === '1' ? 'selected' : ''}}>男性</option>
                                <option value="2" {{ old('gender') === '2' ? 'selected' : ''}}>女性</option>
                            </select>
                        </div>
                        @if ($errors->has('gender'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>                    
                    <div class="form-group row">
                        <label class="col-md-3">要介護認定</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="level">
                                <option value="">選択してください</option>
                                @foreach ($careLevels as $level => $name)
                                    <option value="{{ $level }}" {{ old('level') === "$level" ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('level'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('level') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>    
                    <div class="form-group row">
                        <label class="col-md-3">要介護認定の有効期間</span></label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_start_date" value="{{ old('level_start_date') }}">
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">〜</label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_end_date" value="{{ old('level_end_date') }}">
                        </div>
                        @if ($errors->has('level_start_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('level_start_date') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('level_end_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('level_end_date') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>    
                    <div class="form-group row">
                        <label class="col-md-3">キーパーソン</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_name" value="{{ old('key_person_name') }}" placeholder="氏名" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="key_person_relation" value="{{ old('key_person_relation') }}" placeholder="続柄" autocomplete="off">
                        </div>
                        @if ($errors->has('key_person_name'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_name') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('key_person_relation'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_relation') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>                        
                    <div class="form-group row">
                        <label class="col-md-3">　　住所</label>
                        <div class="col-md-9 col-md-3">
                            <input type="text" class="form-control" name="key_person_address" value="{{ old('key_person_address') }}" placeholder="住所" autocomplete="off">
                        </div>
                        @if ($errors->has('key_person_address'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_address') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">　　電話番号1</label>
                        <div class="col-md-4 col-md-3">
                            <input type="tel" class="form-control" name="key_person_tel1" value="{{ old('key_person_tel1') }}" placeholder="電話番号1" autocomplete="off">
                        </div>
                        @if ($errors->has('key_person_tel1'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_tel1') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>      
                    <div class="form-group row">
                        <label class="col-md-3">　　電話番号2</label>
                        <div class="col-md-4 col-md-3">
                            <input type="tel" class="form-control" name="key_person_tel2" value="{{ old('key_person_tel2') }}" placeholder="電話番号2" autocomplete="off">
                        </div>
                        @if ($errors->has('key_person_tel2'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_tel2') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>      
                    <div class="form-group row">
                        <label class="col-md-3">　　メールアドレス</label>
                        <div class="col-md-9 col-md-3">
                            <input type="email" class="form-control" name="key_person_mail" value="{{ old('key_person_mail') }}" placeholder="メールアドレス" autocomplete="off">
                        </div>
                        @if ($errors->has('key_person_mail'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_mail') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>   
                    <div class="form-group row">
                        <label class=col-md-3>特記</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="note" rows="5">{{ old('note') }}</textarea>
                        </div>
                        @if ($errors->has('note'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('note') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class=col-md-3 for="title">画像</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                        @if ($errors->has('image'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('image') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class=offset-md-3><span class="half-size">※</span>入力必須</label>
                    </div>  
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ route('admin.resident.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection