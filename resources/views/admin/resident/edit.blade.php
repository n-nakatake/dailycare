@extends('layouts.admin')
@section('title', '入居者状況の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        入居者状況の更新に失敗しました。
                    </div> 
                @endif
                <h2>入居者状況の編集</h2>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $residentForm->id }}">
                            削除
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $residentForm->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ $residentForm->last_name }}さんのデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.resident.delete', ['id' => $residentForm->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.resident.update') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-8rem">氏名</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $residentForm->last_name }}">
                            @if ($errors->has('last_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('last_name')}}</strong>
                                </span>
                            @endif  
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : $residentForm->first_name }}">
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
                            <input type="text" class="form-control" name="last_name_k" value="{{ old('last_name_k') ? old('last_name_k') : $residentForm->last_name_k  }}">
                            @if ($errors->has('last_name_k'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('last_name_k')}}</strong>
                                </span>
                            @endif                        
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="first_name_K" value="{{ old('first_name_K') ? old('first_name_K') : $residentForm->first_name_K }}">
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
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="birthday" value="{{ old('birthday') ? old('birthday') : $residentForm->birthday }}">
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
                                <option value="1" {{ old('gender') ? (old('gender') === '1' ? 'selected' : '') : ($residentForm->gender === '1' ? 'selected' : '')}}>男性</option>
                                <option value="2" {{ old('gender') ? (old('gender') === '2' ? 'selected' : '') : ($residentForm->gender === '2' ? 'selected' : '')}}>女性</option>
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
                                <option value="1" {{ old('level') ? (old('level') === '1' ? 'selected' : '') : ($residentForm->level === '1' ? 'selected' : '')}}>要介護１</option>
                                <option value="2" {{ old('level') ? (old('level') === '2' ? 'selected' : '') : ($residentForm->level === '2' ? 'selected' : '')}}>要介護２</option>
                                <option value="3" {{ old('level') ? (old('level') === '3' ? 'selected' : '') : ($residentForm->level === '3' ? 'selected' : '')}}>要介護３</option>
                                <option value="4" {{ old('level') ? (old('level') === '4' ? 'selected' : '') : ($residentForm->level === '4' ? 'selected' : '')}}>要介護４</option>
                                <option value="5" {{ old('level') ? (old('level') === '5' ? 'selected' : '') : ($residentForm->level === '5' ? 'selected' : '')}}>要介護５</option>
                                <option value="6" {{ old('level') ? (old('level') === '6' ? 'selected' : '') : ($residentForm->level === '6' ? 'selected' : '')}}>要支援１</option>
                                <option value="7" {{ old('level') ? (old('level') === '7' ? 'selected' : '') : ($residentForm->level === '7' ? 'selected' : '')}}>要支援２</option>
                                <option value="8" {{ old('level') ? (old('level') === '8' ? 'selected' : '') : ($residentForm->level === '8' ? 'selected' : '')}}>該当なし</option>
                            </select>
                            @if ($errors->has('level'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('level')}}</strong>
                                </span>
                            @endif                        
                        </div>                        
                        <label class="w-5rem">開始日</label>
                        <div class="col-md-2">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_start" value="{{ old('level_start') ? old('level_start') : $residentForm->level_start }}">
                            @if ($errors->has('level_start'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('level_start')}}</strong>
                                </span>
                            @endif  
                        </div>
                        <label class="w-5rem">終了日</label>
                        <div class="col-md-2">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_end" value="{{ old('level_end') ? old('level_end') : $residentForm->level_end  }}">
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
                            <input type="text" class="form-control" name="key_person_name" value="{{ old('key_person_name') ? old('key_person_name') : $residentForm->key_person_name }}">
                            @if ($errors->has('key_person_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('key_person_name')}}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="w-5rem">続柄</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="key_person_relation" value="{{ old('key_person_relation') ? old('key_person_relation') : $residentForm->key_person_relation }}">
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
                            <input type="text" class="form-control" name="key_person_adress" value="{{ old('key_person_adress') ? old('key_person_adress') : $residentForm->key_person_adress }}">
                        </div>
                    </div>           
                    
                    <div class="form-group row">
                        <label class="w-8rem">連絡先１</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_tel1" value="{{ old('key_person_tel1') ? old('key_person_tel1') : $residentForm->key_person_tel1 }}">
                        </div>
                        <label class="w-6rem">連絡先２</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_tel2" value="{{ old('key_person_tel2') ? old('key_person_tel2') : $residentForm->key_person_tel2 }}">
                        </div>
                    </div>      


                    <div class="form-group row">
                        <label class=w-8rem>メールアドレス</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="key_person_mail" value="{{ old('key_person_mail') ? old('key_person_mail') : $residentForm->key_person_mail }}">
                        </div>
                    </div>   
                    
                    <div class="form-group row">
                        <label class=w-8rem>特記</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="note" rows="10">{{ old('note') ? old('note') : $residentForm->note }}</textarea>
                        </div>                        
                    </div>      
                    <div class="form-group row">
                        <label class="cw-5rem" for="image">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                            <div class="form-text text-info">
                                設定中: {{ $residentForm->image_path }}
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                </label>
                            </div>
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
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection