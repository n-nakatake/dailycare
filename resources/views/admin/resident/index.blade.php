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
                                    <td>{{ toWareki('KX年m月d日', str_replace("-","",$resident->birthday)) }}</td>
                                    <td class="no-link">{{ getAge($resident->birthday) }}</td>
                                    @if (isset($careLevels[optional($resident->currentCarelevel)->level]))
                                        <td>{{ $careLevels[$resident->currentCarelevel->level] }}</td>
                                    @else
                                        <td>該当なし</td>
                                    @endif                                      
                                    <td>
                                        <div>
                                            <a class="btn btn-primary me-2" href="{{ route('admin.resident.edit', ['residentId' => $resident->id]) }}">編集</a>
                                            <a class="btn btn-secondary me-2" href="{{ route('admin.resident.leaving', ['residentId' => $resident->id]) }}">
                                                @if ($resident->left_date && isPast($resident->left_date))
                                                    退所済み
                                                @elseif ($resident->left_date && !isPast($resident->left_date))
                                                    退所予定
                                                @else
                                                    退所
                                                @endif
                                            </a>
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
