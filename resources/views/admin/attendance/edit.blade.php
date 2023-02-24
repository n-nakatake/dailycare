@extends('layouts.admin')
@section('title', '出勤者の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        出勤者の編集に失敗しました。
                    </div> 
                @endif
                <h2>出勤者の編集</h2>
                <form class="mt-5" action="{{ route('admin.attendance.update') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-5rem h5">日付</label>
                        <div class="col-md-3">
                            {{ substr($attendanceDate, 0, 4) }}年{{ substr($attendanceDate, 5, 2) }}月{{ substr($attendanceDate, 8, 2) }}日
                        </div>
                        <input type="hidden" name="attendance_date" value="{{ $attendanceDate }}"> 
                        @if ($errors->has('attendance_date'))
                            <span class="small text-danger error">
                            　　<strong>{{-- リンクを表示するためエスケープしない --}}{!! $errors->first('attendance_date') !!}</strong>
                            </span>
                        @endif
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="w-5rem h5">日勤</label>
                        <div class="col-md-10 row">
                            @if ($errors->has('all_attendance_member'))
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('all_attendance_member') }}</strong>
                                </span>
                            @endif
                            {{-- dd($errors) --}}
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
                                        @elseif ($errors->isEmpty() && array_search($user->id, $dayShiftUsers) !== false)
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
                            <label class="w-5rem"></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="part_time_member[{{ $i }}]" value=
                                    @if (old('part_time_member.' . $i))
                                        "{{ old('part_time_member.' . $i) }}"
                                    @elseif ($errors->isEmpty() && isset($partTimeMembers[$i]))
                                        "{{ $partTimeMembers[$i] }}"
                                    @else
                                        ""
                                    @endif
                                 placeholder="非常勤{{ $i + 1 }}">
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
                        <label class="w-5rem h5">夜勤</label>
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
                                        @elseif ($errors->isEmpty() && array_search($user->id, $nightShiftUsers) !== false)
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
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection