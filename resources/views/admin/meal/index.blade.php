@extends('layouts.admin')
@section('title', '登録済みの食事摂取量一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>食事摂取量一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.meal.add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.meal.index') }}" method="get">
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
            <div class="list-meal col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">食事</th>
                                <th width="20%">主食</th>
                                <th width="20%">副食</th>
                                <th width="20%">汁物</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meals as $meal)
                                <tr>
                                    <th>{{ $meal->id }}</th>
                                    <td>{{ Str::limit($meal->meal_bld, 100) }}</td>
                                    <td>{{ Str::limit($meal->meal_intake_rice, 100) }}</td>
                                    <td>{{ Str::limit($meal->meal_intake_side, 100) }}</td>
                                    <td>{{ Str::limit($meal->meal_intake_soup, 100) }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('admin.meal.edit', ['id' => $meal->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.meal.delete', ['id' => $meal->id]) }}">削除</a>
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