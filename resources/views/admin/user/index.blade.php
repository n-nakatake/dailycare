@extends('layouts.admin')
@section('title', '登録済みのユーザー一覧')

@section('content')
    <div class="container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <h2 class="col-md-4">ユーザー一覧</h2>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.user.add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="20%">名前</th>
                                <th width="20%">ユーザーID</th>
                                <th width="20%">資格</th>
                                <th width="20%">権限</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ Str::limit($user->last_name, 100) }} {{ Str::limit($user->first_name, 100) }}</td>
                                    <td>{{ Str::limit($user->user_code, 100) }}</td>
                                    <td>{{ $qualifications[$user->qualification] ? $qualifications[$user->qualification] : 'なし' }}</td>
                                    @if ($user->super_admin_flag )
                                        <td>システム管理者</td>
                                    @elseif ($user->admin_flag)
                                        <td>管理者</td>
                                    @else
                                        <td>--</td>
                                    @endif
                                    <td>
                                        <div>
                                            <a class="btn btn-primary me-2" href="{{ route('admin.user.edit', ['userId' => $user->id]) }}">編集</a>
                                            <a class="btn btn-secondary me-2" href="{{ route('admin.user.retire', ['userId' => $user->id]) }}">
                                                @if ($user->retirement_date && isPast($user->retirement_date))
                                                    退職済み
                                                @elseif ($user->retirement_date && !isPast($user->retirement_date))
                                                    退職予定
                                                @else
                                                    退職
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
