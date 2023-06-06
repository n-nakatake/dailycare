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
                        <label class="col-md-3">利用者 <span class="half-size">※</span></label>
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
                        <label class="w-1rem inline-table ps-0" style="line-height: 2rem;">様</label>
                        @if ($errors->has('resident_id'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('resident_id') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">記録者 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                <option value="">選択してください</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (int) old('user_id') === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>
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
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_date') }}</strong>
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
                            <input type="number" inputmode="numeric" step="0.1" class="form-control" name="vital_kt" value="{{ old('vital_kt') }}" autocomplete="off">
                        </div>
                        <label class="col-md-7 inline-table ps-0" style="line-height: 2rem;">度（小数点第１位まで）</label>
                        @if ($errors->has('vital_kt'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('vital_kt') }}</strong>
                                </span>
                            </div>
                        @endif ($errors->has('vital_bp_u'))
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">血圧</label>
                        <div class="col-md-3">
                            <input type="number" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_u" value="{{ old('vital_bp_u') }}" placeholder="血圧↑" autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="number" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_d" value="{{ old('vital_bp_d') }}" placeholder="血圧↓" autocomplete="off">
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
                            <input type="number" class="form-control" name="vital_hr" value="{{ old('vital_hr') }}" autocomplete="off">
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
                        <label class="col-md-3">身長・体重</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_height" value="{{ old('vital_height') }}" placeholder="身長" autocomplete="off">
                        </div>
                        <label class="w-1rem inline-table ps-0" style="line-height: 2rem;">cm</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_weight" value="{{ old('vital_weight') }}" placeholder="体重" autocomplete="off">
                        </div>
                        <label class="w-1rem inline-table ps-0" style="line-height: 2rem;">kg</label>
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
                            <input type="file" class="form-control-file d-block" name="image">
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
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.vital.index', ['residentId' => $residentId]) }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection