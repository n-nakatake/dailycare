@extends('layouts.admin')
@section('title', 'TOP')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div> 
                @endif
                <div class="row">
                    <div class="col-md-3">
                        <form id="date" action="{{ route('admin.top.index') }}" method="get">
                            <input type="date" class="form-control" name="date" value="{{ request()->input('date') ? request()->input('date') : date('Y-m-d') }}">
                        </form>
                    </div>
                    <div class="col-md-9">
                        @if ($residents->isNotEmpty())
                            <button class="btn btn-secondary mb-1" onclick="location.href='{{ route('admin.vital.index', ['residentId' => $residents->first()->id]) }}'">バイタル一覧</button>
                            <button class="btn btn-secondary mb-1" onclick="location.href='{{ route('admin.bath.index', ['residentId' => $residents->first()->id]) }}'">入浴一覧</button>
                            <button class="btn btn-secondary mb-1" onclick="location.href='{{ route('admin.meal.index', ['residentId' => $residents->first()->id]) }}'">食事一覧</button>
                            <button class="btn btn-secondary mb-1" onclick="location.href='{{ route('admin.excretion.index', ['residentId' => $residents->first()->id]) }}'">排泄一覧</button>
                        @endif
                        <button class="btn btn-secondary mb-1" onclick="location.href='{{ route('admin.resident.index') }}'">入居者一覧</button>
                        @if (Auth::user()->admin_flag || Auth::user()->super_admin_flag)
                            <button class="btn btn-secondary mb-1" onclick="location.href='{{ route('admin.user.index') }}'">ユーザー一覧</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                @if ($dayShiftMembers->isEmpty() && $nightShiftMembers->isEmpty())
                    <div class="row">
                        <div class="col-md-3 mt-3">
                            <a href="{{ route('admin.attendance.add', ['date' => request()->input('date') ?? date('Y-m-d')]) }}" class="btn btn-primary">出勤者を登録</a>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <label class="col-md-1 fw-bold">日勤</label>
                        <div class="col-md-6 row">
                            @if ($dayShiftMembers->isEmpty())
                                <div class="col-md-4">-</div>
                            @else
                                @foreach ($dayShiftMembers as $member)
                                    <div class="col-md-4">{{ getAttendanceMemberName($member) }}</div>
                                @endforeach
                            @endif
                        </div>
                        <label class="col-md-1 fw-bold">夜勤</label>
                        <div class="col-md-4 row">
                            @if ($nightShiftMembers->isEmpty())
                                <div class="col-md-6">-</div>
                            @else
                                @foreach ($nightShiftMembers as $member)
                                    <div class="col-md-6">{{ getAttendanceMemberName($member) }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-12 text-end ps-4 mt-3">
                            <a href="{{ route('admin.attendance.edit', ['attendanceDate' => request()->input('date') ?? date('Y-m-d')]) }}" class="btn btn-primary">出勤者を編集</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12 mx-auto">
                <table id="top" class="table table-dark">
                    <thead>
                        <tr>
                            <th width="15%">氏名</th>
                            <th width="10%">介護度</th>
                            <th width="7%">年齢</th>
                            <th width="20%">バイタル</th>
                            <th width="7%">入浴</th>
                            <th width="20%">食事</th>
                            <th width="11%">排泄</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($residents as $resident)
                            <tr>
                                <td><a href="{{ route('admin.resident.edit', ['residentId' => $resident->id]) }}">{{ $resident->last_name . $resident->first_name }}</a></td>
                                @if (!isset($careLevels[$resident->current_care_level]))
                                    <td class="no-link">該当なし</td>
                                @else
                                    <td class="no-link">{{ $careLevels[$resident->current_care_level] }}</td>
                                @endif
                                <td class="no-link">{{ getAge($resident->birthday) }}</td>
                                <td>
                                    @if ($resident->vitals->isEmpty())
                                        <a href="{{ route('admin.vital.add', ['residentId' => $resident->id, 'date' => request()->input('date')]) }}">-</a>
                                    @else
                                        @php
                                            $vital = $resident->vitals->sortByDesc('vital_time')->first();
                                        @endphp
                                        <a href="{{ route('admin.vital.edit', ['residentId' => $resident->id, 'vitalId' => $vital->id]) }}">
                                            {{ getTime($vital->vital_time) }}
                                            <br>体温：{{ $vital->vital_kt ?? '-' }}℃
                                            <br>血圧：{{ $vital->vital_bp_u ?? '-' }}/{{ $vital->vital_bp_d ?? '-' }}
                                            <br>脈拍：{{ $vital->vital_hr ?? '-' }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($resident->baths->isEmpty())
                                        <a href="{{ route('admin.bath.add', ['residentId' => $resident->id, 'date' => request()->input('date')]) }}">-</a>
                                    @else
                                        <a href="{{ route('admin.bath.edit', ['residentId' => $resident->id, 'bathId' => $resident->baths->sortByDesc('bath_time')->first()->id]) }}">○</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($resident->meals->isEmpty())
                                        <a href="{{ route('admin.meal.add', ['residentId' => $resident->id, 'date' => request()->input('date')]) }}">-</a>
                                    @else
                                        @php
                                            $meal = $resident->meals->sortByDesc('meal_time')->first();
                                        @endphp
                                        <a href="{{ route('admin.meal.edit', ['residentId' => $resident->id, 'mealId' => $resident->meals->first()->id]) }}">
                                            {{ $mealBldOptions[$meal->meal_bld] }}
                                            <br>主食：{{ !is_null($meal->meal_intake_rice) ? $mealIntakeOptions[$meal->meal_intake_rice] : '-' }}
                                            <br>副食：{{ !is_null($meal->meal_intake_side) ? $mealIntakeOptions[$meal->meal_intake_side] : '-' }}
                                            <br>汁物：{{ !is_null($meal->meal_intake_soup) ? $mealIntakeOptions[$meal->meal_intake_soup] : '-' }}
                                        </a>
                                    @endif
                                <td>
                                    <a href="{{ route('admin.excretion.index', ['residentId' => $resident->id]) }}">
                                        排尿：{{ $resident->excretions->where('excretion_flash', true)->count() }}<br>
                                        排便：{{ $resident->excretions->where('excretion_dump', true)->count() }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    $('input').change(function() {
        $('#date').submit();
    });
@endsection