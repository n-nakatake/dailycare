@extends('layouts.admin')
@section('title', '登録済みのバイタル一覧')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <h2 class="col-md-4">バイタル一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.vital.add', ['residentId' => $residentId]) }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <form action="{{ route('admin.vital.index', ['residentId' => $residentId]) }}" method="get">
                    <div class="form-group row">
                        <label class="w-4rem">名前</label>
                        <div class="col-md-3 ps-0">
                            <select id="residentId" class="form-control" name="resident_id">
                                @foreach($residents as $resident)
                                    <option value="{{$resident->id}}" {{ (int)$residentId === $resident->id ? 'selected' : ''}}>{{ $resident->last_name . $resident->first_name }}</option>  
                                @endforeach
                            </select>
                        </div>
                        <label class="w-5rem ms-5">表示月</label>
                        <div class="col-md-3 ps-0">
                            <input type="month" id="vitalYm" class="form-control" name="vital_ym" value="{{ $dateYm }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="15%">日付</th>
                                <th width="15%">時間</th>
                                <th width="10%">体温</th>
                                <th width="10%">血圧（↑）</th>
                                <th width="10%">血圧（↓）</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datesOfMonth as $date)
                                @if (! isset($vitals[$date]))
                                    <tr>
                                        <td>{{ formatDate($date) }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <div>
                                                <a class="btn btn-primary me-2" href="{{ route('admin.vital.add', ['residentId' => $residentId,'date' => $date]) }}">登録</a>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @php
                                        $vitalCount = count($vitals[$date]);
                                    @endphp
                                    @if($vitalCount === 1)
                                        <tr>
                                            <td>{{ formatDate($vitals[$date][0]->vital_time, 0, 10) }}</td>
                                            <td>{{ getTime($vitals[$date][0]->vital_time) }}</td>
                                            <td>{{ !is_null($vitals[$date][0]->vital_kt) ? $vitals[$date][0]->vital_kt : '-' }}</td>
                                            <td>{{ !is_null($vitals[$date][0]->vital_bp_u) ? $vitals[$date][0]->vital_bp_u : '-' }}</td>
                                            <td>{{ !is_null($vitals[$date][0]->vital_bp_d) ? $vitals[$date][0]->vital_bp_d : '-' }}</td>
                                            <td>
                                                <div>
                                                    <a class="btn btn-primary me-2" href="{{ route('admin.vital.edit', ['residentId' => $residentId,'vitalId' => $vitals[$date][0]->id]) }}">編集</a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $vitals[$date][0]->id }}">
                                                      削除
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade text-dark" id="confirmModal{{ $vitals[$date][0]->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <p>{{ formatDatetime($vitals[$date][0]->vital_time, 0, 10) }}のバイタルデータを削除してよろしいですか？</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.vital.delete', ['residentId' => $residentId,'vitalId' => $vitals[$date][0]->id]) }}'">削除</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($vitals[$date] as $vitalTime)
                                            <tr>
                                                @if ($loop->first)
                                                    <td rowspan={{$vitalCount}}>
                                                        {{ formatDate($vitalTime->vital_time, 0, 10) }}
                                                    </td>
                                                @endif
                                                <td>{{ getTime($vitalTime->vital_time) }}</td>
                                                <td>{{ !is_null($vitalTime->vital_kt) ? $vitalTime->vital_kt : '-' }}</td>
                                                <td>{{ !is_null($vitalTime->vital_bp_u) ? $vitalTime->vital_bp_u : '-' }}</td>
                                                <td>{{ !is_null($vitalTime->vital_bp_d) ? $vitalTime->vital_bp_d : '-' }}</td>
                                                <td>
                                                    <div>
                                                        <a class="btn btn-primary me-2" href="{{ route('admin.vital.edit', ['residentId' => $residentId,'vitalId' =>  $vitalTime->id]) }}">編集</a>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $vitalTime->id }}">
                                                          削除
                                                        </button>
                                                        
                                                        <!-- Modal -->
                                                        <div class="modal fade text-dark" id="confirmModal{{ $vitalTime->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p>{{ formatDate($vitalTime->vital_time, 0, 10) . ' ' . getTime($vitalTime->vital_time) }}の入浴データを削除してよろしいですか？</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                        <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.vital.delete', ['residentId' => $residentId,'vitalId' => $vitalTime->id]) }}'">削除</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    $('input, select').change(function() {
        const indexUrl = "{{ trim(route('admin.vital.index', ['residentId' => $residentId]), '0123456789') }}";
        const residentId = $('#residentId').val();
        const vitalYm = $('#vitalYm').val();
        location.href= indexUrl + residentId + '?vital_ym=' + vitalYm;
    });
@endsection