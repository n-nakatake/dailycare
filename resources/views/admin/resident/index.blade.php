@extends('layouts.admin')
@section('title', '登録済みの入居者一覧')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <h2 class="col-md-4">入居者一覧</h2>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.resident.add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="15%">名前</th>
                                <th width="15%">性別</th>
                                <th width="20%">誕生日</th>
                                <th width="15%">年齢</th>
                                <th width="15%">介護度</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($residents as $resident)
                                <tr>
                                    <td>{{ Str::limit($resident->last_name, 100) }} {{ Str::limit($resident->first_name, 100) }}</td>
                                    @if ($resident->gender == 1 )
                                        <td>男性</td>
                                    @else
                                        <td>女性</td>
                                    @endif
                                    <td>{{toWareki('KX年m月d日', str_replace("-","",$resident->birthday))}}</td>
                                    <td class="no-link">{{ getAge($resident->birthday) }}</td>
                                    @if ($resident->level == 1 )
                                        <td>要介護１</td>
                                    @elseif ($resident->level == 2 )
                                        <td>要介護２</td>
                                    @elseif ($resident->level == 3 )
                                        <td>要介護３</td>
                                    @elseif ($resident->level == 4 )
                                        <td>要介護４</td>
                                    @elseif ($resident->level == 5 )
                                        <td>要介護５</td>
                                    @elseif ($resident->level == 6 )
                                        <td>要支援１</td>
                                    @elseif ($resident->level == 7 )
                                        <td>要支援２</td>
                                    @elseif ($resident->level == 8 )
                                        <td>該当なし</td>
                                    @endif                                      
                                    <td>
                                        <div>
                                            <a class="btn btn-primary me-2" href="{{ route('admin.resident.edit', ['id' => $resident->id]) }}">編集</a>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $resident->id }}">
                                              削除
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade text-dark" id="confirmModal{{ $resident->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <p>{{ $resident->last_name }}{{ $resident->first_name }}さんの入居者データを削除してよろしいですか？</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                            <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.resident.delete', ['id' => $resident->id]) }}'">削除</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--
@section('script')
    $('input, select').change(function() {
        const indexUrl = "{{ trim(route('admin.resident.index', ['residentId' => $residentId]), '0123456789') }}";
        const residentId = $('#residentId').val();
        const residentYm = $('#residentYm').val();
        location.href= indexUrl + residentId + '?resident_ym=' + residentYm;
    });
@endsection-->
--}}