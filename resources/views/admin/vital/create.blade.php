@extends('layouts.admin')
@section('title', 'バイタル登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        バイタルの登録に失敗しました。
                    </div> 
                @endif
                <h2>バイタル登録</h2>
                <form class="mt-5" action="{{ route('admin.vital.create') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-5rem">利用者</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="resident_id">
                                @foreach($residents as $resident)
                                    <option value="{{$resident->id}}" 
                                        @if ((int) old('resident_id') > 0)
                                            {{ (int) old('resident_id') === $resident->id ? 'selected' : '' }}
                                        @elseif ($residentId === $resident->id)
                                            selected
                                        @endif
                                    >
                                        {{ $resident->last_name . $resident->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1">様</label>
                        @if ($errors->has('resident_id'))
                            <span class="small text-danger error">
                            　　<strong>{{ $errors->first('resident_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">記録者</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                <option value="">選択してください</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (int) old('user_id') === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>
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
                            <input type="date" class="form-control" name="vital_date" value=
                                 @if(old('vital_date'))
                                    "{{ old('vital_date') }}"
                                 @elseif(request()->input('date'))
                                    "{{ request()->input('date') }}"
                                 @else
                                    "{{ date("Y-m-d") }}"
                                 @endif
                            >
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="vital_time" value="{{ old('vital_time') ? old('vital_time') : date("H:i")}}">
                        </div>
                        @if ($errors->has('vital_date'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('vital_date')}}</strong>
                            </span>
                        @endif
                        @if ($errors->has('vital_time'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('vital_time')}}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">体温</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_kt" value="{{ old('vital_kt') }}">
                        </div>
                        <label class="w-5rem">血圧↑</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_u" value="{{ old('vital_bp_u') }}">
                        </div>
                        <label class="w-5rem">血圧↓</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_d" value="{{ old('vital_bp_d') }}">
                        </div>
                        @if ($errors->has('vital_kt'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('vital_kt')}}</strong>
                            </span>
                        @elseif ($errors->has('vital_bp_u'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('vital_bp_u')}}</strong>
                            </span>
                        @elseif ($errors->has('vital_bp_d'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('vital_bp_d')}}</strong>
                            </span>
                        @endif
                    
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">心拍数</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_hr" value="{{ old('vital_hr') }}">
                        </div>                          <label class="w-5rem">身長</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_height" value="{{ old('vital_height') }}">
                        </div>
                        <label class="w-5rem">体重</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_weight" value="{{ old('vital_weight') }}">
                        </div>                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">特記</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="vital_note" rows="5">{{ old('vital_note') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">画像</label>
                        <div class="col-md-11">
                            <input type="file" class="form-control-file" name="vital_image_path">
                        </div>
                    </div>
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.vital.index', ['residentId' => $residentId]) }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection