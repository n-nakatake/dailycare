@extends('layouts.admin')
@section('title', '登録済みの排泄状況一覧')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <h2 class="col-md-4">排泄状況一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.excretion.add', ['residentId' => $residentId]) }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <form action="{{ route('admin.excretion.index', ['residentId' => $residentId]) }}" method="get">
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
                            <input type="month" id="excretionYm" class="form-control" name="excretion_ym" value="{{ $dateYm }}">
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
                                <th width="35%">排泄</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datesOfMonth as $date)
                                @if (! isset($excretions[$date]))
                                    <tr>
                                        <td>{{ formatDate($date) }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <div>
                                                <a class="btn btn-primary me-2" href="{{ route('admin.excretion.add', ['residentId' => $residentId,'date' => $date]) }}">登録</a>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @php
                                        $excretionCount = count($excretions[$date]);
                                    @endphp
                                    @if($excretionCount === 1)
                                        <tr>
                                            <td>{{ formatDate($excretions[$date][0]->excretion_time, 0, 10) }}</td>
                                            <td>{{ getTime($excretions[$date][0]->excretion_time) }}</td>
                                            <td>{{ getExcretionType($excretions[$date][0]->excretion_flash,$excretions[$date][0]->excretion_dump) }}</td>
                                            <td>
                                                <div>
                                                    <a class="btn btn-primary me-2" href="{{ route('admin.excretion.edit', ['residentId' => $residentId,'excretionId' => $excretions[$date][0]->id]) }}">編集</a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $excretions[$date][0]->id }}">
                                                      削除
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade text-dark" id="confirmModal{{ $excretions[$date][0]->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <p>{{ formatDatetime($excretions[$date][0]->excretion_time, 0, 10) }}の排泄データを削除してよろしいですか？</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.excretion.delete', ['residentId' => $residentId,'excretionId' => $excretions[$date][0]->id]) }}'">削除</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($excretions[$date] as $excretionTime)
                                            <tr>
                                                @if ($loop->first)
                                                    <td rowspan={{$excretionCount}}>
                                                        {{ formatDate($excretionTime->excretion_time, 0, 10) }}
                                                    </td>
                                                @endif
                                                <td>{{ getTime($excretionTime->excretion_time) }}</td>
                                                <td>{{ getExcretionType($excretionTime->excretion_flash,$excretionTime->excretion_dump) }}</td>
                                                <td>
                                                    <div>
                                                        <a class="btn btn-primary me-2" href="{{ route('admin.excretion.edit', ['residentId' => $residentId,'excretionId' =>  $excretionTime->id]) }}">編集</a>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $excretionTime->id }}">
                                                          削除
                                                        </button>
                                                        
                                                        <!-- Modal -->
                                                        <div class="modal fade text-dark" id="confirmModal{{ $excretionTime->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p>{{ formatDate($excretionTime->excretion_time, 0, 10) . ' ' . getTime($excretionTime->excretion_time) }}の排泄データを削除してよろしいですか？</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                        <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.excretion.delete', ['residentId' => $residentId,'excretionId' => $excretionTime->id]) }}'">削除</a>
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
        const indexUrl = "{{ trim(route('admin.excretion.index', ['residentId' => $residentId]), '0123456789') }}";
        const residentId = $('#residentId').val();
        const excretionYm = $('#excretionYm').val();
        location.href= indexUrl + residentId + '?excretion_ym=' + excretionYm;
    });
@endsection