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
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $residentForm->id }}">
                        削除
                    </button>
                </div>
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
                <form class="mt-5" action="{{ route('admin.resident.update', ['residentId' => $residentForm->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">氏名 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $residentForm->last_name }}" placeholder="性" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : $residentForm->first_name }}" placeholder="名" autocomplete="off">
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
                            <input type="text" class="form-control" name="last_name_k" value="{{ old('last_name_k') ? old('last_name_k') : $residentForm->last_name_k }}" placeholder="セイ" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="first_name_k" value="{{ old('first_name_k') ? old('first_name_k') : $residentForm->first_name_k }}" placeholder="メイ" autocomplete="off">
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
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="birthday" value="{{ old('birthday') ? old('birthday') : $residentForm->birthday }}">
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
                                <option value="1" {{ old('gender') ? (old('gender') === '1' ? 'selected' : '') : ($residentForm->gender === '1' ? 'selected' : '')}}>男性</option>
                                <option value="2" {{ old('gender') ? (old('gender') === '2' ? 'selected' : '') : ($residentForm->gender === '2' ? 'selected' : '')}}>女性</option>
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
                                    <option value="{{ $level }}" {{ old('level') ? (old('level') === "$level" ? 'selected' : '') : (optional($careCertifications->first())->level === $level ? 'selected' : '') }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="care_certification_id" value="{{ optional($careCertifications->first())->id }}">
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
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_start_date" value="{{ old('level_start_date') ? old('level_start_date') : getDateOnly(optional($careCertifications->first())->start_date) }}">
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">〜</label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="level_end_date" value="{{ old('level_end_date') ? old('level_end_date') : getDateOnly(optional($careCertifications->first())->end_date) }}">
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
                        <label class="col-md-3">新しい要介護認定</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="new_level">
                                <option value="">選択してください</option>
                                @foreach ($careLevels as $level => $name)
                                    <option value="{{ $level }}" {{ old('new_level') === "$level" ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('new_level'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('new_level') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">新しい要介護認定の有効期間</label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="new_level_start_date" value="{{ old('new_level_start_date') }}">
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">〜</label>
                        <div class="col-md-3">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="new_level_end_date" value="{{ old('new_level_end_date') }}">
                        </div>
                        @if ($errors->has('new_level_start_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('new_level_start_date') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('new_level_end_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('new_level_end_date') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    @if ($careCertifications->count() > 1)
                        <div class="form-group row">
                            <label class="col-md-3">過去の介護認定</span></label>
                            <div class="col-md-9">
                                @foreach ($careCertifications as $careCertification)
                                    @if (! $loop->first)
                                        <p>{{ $careLevels[$careCertification->level] }}：
                                            @if ($careCertification->start_date && $careCertification->end_date)
                                                {{ formatDateWithYear($careCertification->start_date) }} 〜 {{ formatDateWithYear($careCertification->end_date) }}
                                            @endif
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-3">キーパーソン</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="key_person_name" value="{{ old('key_person_name') ? old('key_person_name') : $residentForm->key_person_name }}" placeholder="氏名" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="key_person_relation" value="{{ old('key_person_relation') ? old('key_person_relation') : $residentForm->key_person_relation }}" placeholder="続柄" autocomplete="off">
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
                            <input type="text" class="form-control" name="key_person_address" value="{{ old('key_person_address') ? old('key_person_address') : decrypt($residentForm->key_person_address) }}" placeholder="住所" autocomplete="off">
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
                            <input type="tel" class="form-control" name="key_person_tel1" value="{{ old('key_person_tel1') ? old('key_person_tel1') : decrypt($residentForm->key_person_tel1) }}" placeholder="電話番号1" autocomplete="off">
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
                            <input type="tel" class="form-control" name="key_person_tel2" value="{{ old('key_person_tel2') ? old('key_person_tel2') : decrypt($residentForm->key_person_tel2) }}" placeholder="電話番号2" autocomplete="off">
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
                            <input type="email" class="form-control" name="key_person_mail" value="{{ old('key_person_mail') ? old('key_person_mail') : decrypt($residentForm->key_person_mail) }}" placeholder="メールアドレス" autocomplete="off">
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
                            <textarea class="form-control" name="note" rows="5">{{ old('note') ? old('note') : $residentForm->note }}</textarea>
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
                        <label class="col-md-3">画像</label>
                        <div class="col-md-9">
                            @if ($residentForm->image_path)
                                <img src="{{ asset($residentForm->image_path) }}" style="max-height:300px;"/>
                                <div class="form-check mt-1">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                    </label>
                                </div>
                                <input type="file" class="form-control-file d-block mt-3" name="image">
                            @else
                                <input type="file" class="form-control-file d-block" name="image">
                            @endif
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
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
