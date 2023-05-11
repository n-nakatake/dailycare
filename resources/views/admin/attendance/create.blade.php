@extends('layouts.admin')
@section('title', '出勤者の登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        出勤者の登録に失敗しました。
                    </div> 
                @endif
                <h2>出勤者の登録</h2>
                <form class="mt-5" action="{{ route('admin.attendance.create') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-2 h5">日付</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="attendance_date" value="{{ old('attendance_date') ? old('attendance_date') : request()->input('date') }}">
                        </div>
                        @if ($errors->has('attendance_date'))
                            <span class="small text-danger error">
                            　　<strong>{!! $errors->first('attendance_date') !!}</strong>
                            </span>
                        @endif
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-md-2 h5">日勤</label>
                        <div class="col-md-10 row">
                            @if ($errors->has('all_attendance_member'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('all_attendance_member') }}</strong>
                                </span>
                            @endif
                            @if ($errors->has('day_shift_user_id.0'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('day_shift_user_id.0') }}</strong>
                                </span>
                            @endif
                            @foreach ($users as $key => $user)
                                <div class="col-md-4 mb-4">
                                    <input type="checkbox" id="day_shift_user_id{{ $key }}" name="day_shift_user_id[{{ $key }}]" value="{{ $user->id }}" 
                                        @if (is_array(old('day_shift_user_id')) && array_keys(old('day_shift_user_id'), $user->id))
                                            checked
                                        @endif
                                    >    
                                    <label for="day_shift_user_id{{ $key }}">{{ $user->last_name . $user->first_name }}</label>
                                    @if ($errors->has('day_shift_user_id.' . $key))
                                        <span class="small text-danger error-left">
                                        　　<strong>{{ $errors->first('day_shift_user_id.' . $key) }}</strong>
                                        </span>
                                    @endif            
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @for ($i = 0; $i < 3; $i++)
                        <div class="form-group row">
                            <!--<label class="w-5rem"></label>-->
                            <div class="offset-md-2 col-md-3">
                                <input type="text" class="form-control" name="part_time_member[{{ $i }}]" value="{{ old('part_time_member.' . $i) ?? old('part_time_member.' . $i) }}" placeholder="非常勤{{ $i + 1 }}">
                            </div>
                            @if (old('part_time_member.' . $i))
                                @if ($errors->has('part_time_member.' . $i))
                                    <span class="small text-danger error">
                                    　　<strong>{{ $errors->first('part_time_member.' . $i) }}</strong>
                                    </span>
                                @endif
                            @endif
                        </div>
                    @endfor

                    <hr>
                    <div class="form-group row">
                        <label class="col-md-2 h5">夜勤</label>
                        <div class="col-md-10 row">
                            @if ($errors->has('all_attendance_member'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('all_attendance_member') }}</strong>
                                </span>
                            @endif
                            @foreach ($users as $key => $user)
                                <div class="col-md-4 mb-4">
                                    <input type="checkbox" id="night_shift_user_id{{ $key }}" name="night_shift_user_id[{{ $key }}]" value="{{ $user->id }}" 
                                        @if (is_array(old('night_shift_user_id')) && array_keys(old('night_shift_user_id'), $user->id))
                                            checked
                                        @endif
                                    >    
                                    <label for="night_shift_user_id{{ $key }}">{{ $user->last_name . $user->first_name }}</label>
                                    @if ($errors->has('night_shift_user_id.' . $key))
                                        <span class="small text-danger error-left">
                                        　　<strong>{{ $errors->first('night_shift_user_id.' . $key) }}</strong>
                                        </span>
                                    @endif            

                                </div>
                            @endforeach
                        </div>
                    </div>
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.top.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection