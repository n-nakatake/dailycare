@extends('layouts.admin')
@section('title', '入居者の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        入居者の更新に失敗しました。
                    </div> 
                @endif
                <h2>入居者の編集</h2>
                <div class="col-md-12 text-end">
                    <a class="btn btn-secondary" href="{{ route('admin.resident.leaving', ['residentId' => $residentForm->id]) }}">
                        退所
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $residentForm->id }}">
                        削除
                    </button>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $residentForm->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ $residentForm->last_name . $residentForm->first_name }}様のデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.resident.delete', ['residentId' => $residentForm->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.resident.update', ['residentId' => $residentForm->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">氏名 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $residentForm->last_name }}" placeholder="性">
                            @if ($errors->has('last_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif                         
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : $residentForm->first_name }}" placeholder="名">
                            @if ($errors->has('first_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">氏名（カナ） <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="last_name_k" value="{{ old('last_name_k') ? old('last_name_k') : $residentForm->last_name_k }}" placeholder="セイ">
                            @if ($errors->has('last_name_k'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('last_name_k') }}</strong>
                                </span>
                            @endif                        
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="first_name_k" value="{{ old('first_name_k') ? old('first_name_k') : $residentForm->first_name_k }}" placeholder="メイ">
                            @if ($errors->has('first_name_k'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('first_name_k') }}</strong>
                                </span>
                            @endif
                        </div> 
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">誕生日 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="birthday" value="{{ old('birthday') ? old('birthday') : $residentForm->birthday }}">
                            @if ($errors->has('birthday'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="col-md-3">性別 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <select  class="form-control" name="gender">
                                <option value="1" {{ old('gender') ? (old('gender') === '1' ? 'selected' : '') : ($residentForm->gender === '1' ? 'selected' : '')}}>男性</option>
                                <option value="2" {{ old('gender') ? (old('gender') === '2' ? 'selected' : '') : ($residentForm->gender === '2' ? 'selected' : '')}}>女性</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @if ($careCertifications->count() > 1)
                        <div class="form-group row">
                            <label class="col-md-3">過去の要介護認定</span></label>
                            <div class="col-md-9">
                                @foreach ($careCertifications as $careCertification)
                                    @if (! $loop->last)
                                        <p>{{ $careLevels[$careCertification->level] }}：{{ formatDateWithYear($careCertification->start_date) }} 〜 {{ formatDateWithYear($careCertification->end_date) }}</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-3">要介護認定 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <select  class="form-control" name="level">
                                @foreach ($careLevels as $level => $name)
                                    <option value="{{ $level }}" {{ old('level') ? (old('level') === "$level" ? 'selected' : '') : (optional($careCertifications->last())->level === $level ? 'selected' : '') }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('level'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('level') }}</strong>
                                </span>
                            @endif
                            <input type="hidden" name="care_certification_id" value="{{ optional($careCertifications->last())->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">要介護認定の有効期間 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_start_date" value="{{ old('level_start_date') ? old('level_start_date') : getDateOnly(optional($careCertifications->last())->start_date) }}">
                            @if ($errors->has('level_start_date'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('level_start_date') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">〜</label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_end_date" value="{{ old('level_end_date') ? old('level_end_date') : getDateOnly(optional($careCertifications->last())->end_date) }}">
                            @if ($errors->has('level_end_date'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('level_end_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">新しい要介護認定</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="new_level">
                                <option value="">選択してください</option>
                                @foreach ($careLevels as $level => $name)
                                    <option value="{{ $level }}" {{ old('new_level') === "$level" ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('new_level'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('new_level') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">新しい要介護認定の有効期間</label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="new_level_start_date" value="{{ old('new_level_start_date') }}">
                            @if ($errors->has('new_level_start_date'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('new_level_start_date') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">〜</label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="new_level_end_date" value="{{ old('new_level_end_date') }}">
                            @if ($errors->has('new_level_end_date'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('new_level_end_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">キーパーソン</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_name" value="{{ old('key_person_name') ? old('key_person_name') : $residentForm->key_person_name }}" placeholder="氏名">
                            @if ($errors->has('key_person_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="key_person_relation" value="{{ old('key_person_relation') ? old('key_person_relation') : $residentForm->key_person_relation }}" placeholder="続柄">
                            @if ($errors->has('key_person_relation'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_relation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                        
                    <div class="form-group row">
                        <label class="col-md-3">　　住所</label>
                        <div class="col-md-9 col-md-3">
                            <input type="text" class="form-control" name="key_person_address" value="{{ old('key_person_address') ? old('key_person_address') : decrypt($residentForm->key_person_address) }}" placeholder="住所">
                            @if ($errors->has('key_person_address'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">　　電話番号1</label>
                        <div class="col-md-4 col-md-3">
                            <input type="tel" class="form-control" name="key_person_tel1" value="{{ old('key_person_tel1') ? old('key_person_tel1') : decrypt($residentForm->key_person_tel1) }}" placeholder="電話番号1">
                            @if ($errors->has('key_person_tel1'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_tel1') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>      
                    <div class="form-group row">
                        <label class="col-md-3">　　電話番号2</label>
                        <div class="col-md-4 col-md-3">
                            <input type="tel" class="form-control" name="key_person_tel2" value="{{ old('key_person_tel2') ? old('key_person_tel2') : decrypt($residentForm->key_person_tel2) }}" placeholder="電話番号2">
                            @if ($errors->has('key_person_tel2'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_tel2') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>      
                    <div class="form-group row">
                        <label class="col-md-3">　　メールアドレス</label>
                        <div class="col-md-9 col-md-3">
                            <input type="email" class="form-control" name="key_person_mail" value="{{ old('key_person_mail') ? old('key_person_mail') : decrypt($residentForm->key_person_mail) }}" placeholder="メールアドレス">
                            @if ($errors->has('key_person_mail'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('key_person_mail') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class=col-md-3>特記</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="note" rows="5">{{ old('note') ? old('note') : $residentForm->note }}</textarea>
                            @if ($errors->has('note'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('note') }}</strong>
                                </span>
                            @endif
                        </div>                        
                    </div>      
                    <div class="form-group row">
                        <label class=col-md-3 for="title">画像</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file" name="image">
                            @if ($errors->has('image'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class=offset-md-3>※入力必須</label>
                    </div>  
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ route('admin.resident.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
