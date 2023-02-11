@extends('layouts.admin')
@section('title', '登録済みの入浴状況一覧')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <h2 class="col-md-4">入浴状況一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.bath.add', ['residentId' => $residentId]) }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <form action="{{ route('admin.bath.index', ['residentId' => $residentId]) }}" method="get">
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
                            <input type="month" id="bathYm" class="form-control" name="bath_ym" value="{{ $date }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-bath col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="15%">日付</th>
                                <th width="15%">時間</th>
                                <th width="35%">入浴方法</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($baths as $bath)
                                @php
                                    $bathCount = count($bath);
                                @endphp
                                @if($bathCount === 1)
                                    <tr>
                                        <td>{{ substr($bath[0]->bath_time, 0, 10) }}</td>
                                        <td>{{ substr($bath[0]->bath_time, 11, 5) }}</td>
                                        <td>{{ getBathMethodName($bath[0]->bath_method) }}</td>
                                        <td>
                                            <div>
                                                <a class="btn btn-primary me-2" href="{{ route('admin.bath.edit', ['residentId' => $bath[0]->resident_id,'bathId' => $bath[0]->id]) }}">編集</a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $bath[0]->id }}">
                                                  削除
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade text-dark" id="confirmModal{{ $bath[0]->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <p>{{ substr($bath[0]->bath_time, 0, -3) }}の入浴データを削除してよろしいですか？</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.bath.delete', ['residentId' => $bath[0]->resident_id,'bathId' => $bath[0]->id]) }}'">削除</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($bath as $bathTime)
                                        <tr>
                                            @if ($loop->first)
                                                <td rowspan={{$bathCount}}>
                                                    {{ substr($bathTime->bath_time, 0, 10) }}
                                                </td>
                                            @endif
                                            <td>{{ substr($bathTime->bath_time, 11, 5) }}</td>
                                            <td>{{ getBathMethodName($bathTime->bath_method) }}</td>
                                            <td>
                                                <div>
                                                    <a class="btn btn-primary me-2" href="{{ route('admin.bath.edit', ['residentId' => $bathTime->resident_id,'bathId' =>  $bathTime->id]) }}">編集</a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $bathTime->id }}">
                                                      削除
                                                    </button>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade text-dark" id="confirmModal{{ $bathTime->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <p>{{ substr($bathTime->bath_time, 0, -3) }}の入浴データを削除してよろしいですか？</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.bath.delete', ['residentId' => $bathTime->resident_id,'bathId' => $bathTime->id]) }}'">削除</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
        const indexUrl = "{{ trim(route('admin.bath.index', ['residentId' => $residentId]), '0123456789') }}";
        const residentId = $('#residentId').val();
        const bathYm = $('#bathYm').val();
        location.href= indexUrl + residentId + '?bath_ym=' + bathYm;
    });
@endsection