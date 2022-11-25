@extends('layouts.admin')
@section('title', '登録済みの入浴状況一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>入浴状況一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.bath.add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.bath.index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">名前</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
                        </div>
                        <div class="col-md-2">
                            @csrf
                            <input type="submit" class="btn btn-primary" value="検索">
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
                                <th width="10%">ID</th>
                                <th width="40%">時間</th>
                                <th width="40%">入浴方法</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($baths as $bath)
                                <tr>
                                    <th>{{ $bath->id }}</th>
                                    <td>{{ Str::limit($bath->bath_time, 100) }}</td>
                                    <td>{{ Str::limit($bath->bath_method, 100) }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('admin.bath.edit', ['id' => $bath->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.bath.delete', ['id' => $bath->id]) }}">削除</a>
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