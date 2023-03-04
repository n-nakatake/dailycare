@extends('layouts.admin')
@section('title', 'バイタル編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        バイタルの更新に失敗しました。
                    </div> 
                @endif
                <h2>バイタル編集</h2>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $vitalForm->id }}">
                            削除
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $vitalForm->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ formatDate($vitalForm->vital_time) }}のデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.vital.delete', ['residentId' => $vitalForm->resident_id,'vitalId' => $vitalForm->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.vital.update',['residentId' => $vitalForm->resident_id, 'vitalId' => $vitalForm->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-5rem">利用者</label>
                        <div class="col-md-4">
                            {{ $vitalForm->resident->last_name . $vitalForm->resident->first_name }} 様
                        </div>
                        <input type="hidden" name="resident_id" value="{{ $vitalForm->resident_id }}">
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">記録者</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        @if (old('user_id') > 0)
                                            {{ (int) old('user_id') === $user->id ? 'selected' : ''}}
                                        @elseif ($vitalForm->user_id === $user->id)
                                            selected
                                        @endif
                                    >
                                        {{ $user->last_name . $user->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('user_id'))
                            <span class="small text-danger error">
                            　　<strong>{{ $errors->first('user_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">日時</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="vital_date" value="{{ old('vital_date') ? old('vital_date') : substr($vitalForm->vital_time, 0, 10) }}">
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="vital_time" value="{{ old('vital_time') ? old('vital_time') : substr($vitalForm->vital_time, 11, 5) }}">
                        </div>
                        @if ($errors->has('vital_date'))
                            <span class="small text-danger error">
                            　　<strong>{!! $errors->first('vital_date') !!}</strong>
                            </span>
                        @endif
                        @if ($errors->has('vital_time'))
                            <span class="small text-danger error">
                            　　<strong>{{ $errors->first('vital_time') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">体温</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_kt" value="{{ old('vital_kt') ? old('vital_kt') : $vitalForm->vital_kt   }}">
                        </div>
                        <label class="w-5rem">血圧</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_u" value="{{ old('vital_bp_u') ? old('vital_bp_u') : $vitalForm->vital_bp_u   }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_d" value="{{ old('vital_bp_d') ? old('vital_bp_d') : $vitalForm->vital_bp_d   }}">
                        </div>    
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">心拍数</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_hr" value="{{ old('vital_hr') ? old('vital_hr') : $vitalForm->vital_hr   }}">
                        </div>
                        <label class="w-5rem">身長</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_height" value="{{ old('vital_height') ? old('vital_height') : $vitalForm->vital_height   }}">
                        </div>
                        <label class="w-5rem">体重</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_weight" value="{{ old('vital_weight') ? old('vital_weight') : $vitalForm->vital_weight   }}">
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">特記</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="vital_note" rows="5">{{ old('vital_note') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="cw-5rem" for="image">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                            <div class="form-text text-info">
                                設定中: {{ $vitalForm->vital_image_path }}
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                </label>
                            </div>
                        </div>
                    </div>

<!--                    <div class="form-group row">
                        <label class="col-md-1">画像</label>
                        <div class="col-md-11">
                            <input type="file" class="form-control-file" name="vital_image_path">
                        </div>
                    </div>
-->
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.vital.index', ['residentId' => $vitalForm->resident_id]) }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection