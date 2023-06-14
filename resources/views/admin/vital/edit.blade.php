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
                        <label class="col-md-3">利用者</label>
                        <div class="col-md-4">
                            {{ $vitalForm->resident->last_name . $vitalForm->resident->first_name }} 様
                        </div>
                        <input type="hidden" name="resident_id" value="{{ $vitalForm->resident_id }}">
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">記録者 <span class="half-size">※</span></label>
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
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">日時 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="vital_date" value="{{ old('vital_date') ? old('vital_date') : substr($vitalForm->vital_time, 0, 10) }}">
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="vital_time" value="{{ old('vital_time') ? old('vital_time') : substr($vitalForm->vital_time, 11, 5) }}">
                        </div>
                        @if ($errors->has('vital_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{!! $errors->first('vital_date') !!}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('vital_time'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_time') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">体温</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_kt" value="{{ old('vital_kt') ? old('vital_kt') : $vitalForm->vital_kt }}" autocomplete="off">
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">度</label>
                        @if ($errors->has('vital_kt'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('vital_kt')}}</strong>
                                </span>
                            </div>
                        @endif ($errors->has('vital_bp_u'))
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">血圧</label>
                        <div class="col-md-2">
                            <input type="number" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_u" value="{{ old('vital_bp_u') ? old('vital_bp_u') : $vitalForm->vital_bp_u }}" placeholder="血圧↑" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <input type="number" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_d" value="{{ old('vital_bp_d') ? old('vital_bp_d') : $vitalForm->vital_bp_d }}" placeholder="血圧↓" autocomplete="off">
                        </div>    
                        @if ($errors->has('vital_bp_u'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_bp_u') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('vital_bp_d'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_bp_d') }}</strong>
                                </span>
                            </div>
                        @endif                    
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">心拍数</label>
                        <div class="col-md-2">
                            <input type="number" inputmode="numeric" pattern="\d*" class="form-control" name="vital_hr" value="{{ old('vital_hr') ? old('vital_hr') : $vitalForm->vital_hr }}" autocomplete="off">
                        </div>
                        <label class="w-1rem inline-table ps-0" style="line-height: 2rem;">bpm</label>
                        @if ($errors->has('vital_hr'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_hr') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">身長・体重
                        </label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_height" value="{{ old('vital_height') ? old('vital_height') : $vitalForm->vital_height }}" placeholder="身長" autocomplete="off">
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">cm</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_weight" value="{{ old('vital_weight') ? old('vital_weight') : $vitalForm->vital_weight }}" placeholder="体重" autocomplete="off">
                        </div>
                        <label class="w-1rem inline-table" style="line-height: 2rem;">kg</label>
                        @if ($errors->has('vital_height'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_height') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('vital_weight'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_weight') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">特記</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="vital_note" rows="5">{{ old('vital_note') }}</textarea>
                        </div>
                        @if ($errors->has('vital_note'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_note') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3">画像</label>
                        <div class="col-md-9">
                            @if ($vitalForm->vital_image_path)
                                <img src="{{ asset($vitalForm->vital_image_path) }}" style="max-height:300px;"/>
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