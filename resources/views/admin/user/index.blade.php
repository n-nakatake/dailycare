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
        <div class="row">
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
                                    @if ($user->qualification == 1 )
                                        <td>介護福祉士</td>
                                    @elseif ($user->qualification == 2 )
                                        <td>初任者研修修了</td>
                                    @elseif ($user->qualification == 3 )
                                        <td>ヘルパー2級</td>
                                    @elseif ($user->qualification == 4 )
                                        <td>ヘルパー1級</td>
                                    @elseif ($user->qualification == 5 )
                                        <td>介護支援専門員</td>
                                    @elseif ($user->qualification == 6 )
                                        <td>なし</td>
                                    @endif
                                    @if ($user->admin_flag || $user->super_admin_flag )
                                        <td>管理者</td>
                                    @else
                                        <td>--</td>
                                    @endif
                                    <td>
                                        <div>
                                            <a class="btn btn-primary me-2" href="{{ route('admin.user.edit', ['userId' => $user->id]) }}">編集</a>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $user->id }}">削除</button>
                                            <!-- Modal -->
                                            <div class="modal fade text-dark" id="confirmModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <p>{{ $user->last_name }}{{ $user->first_name }}さんのユーザーデータを削除してよろしいですか？</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                            <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.user.delete', ['id' => $user->id]) }}'">削除</a>
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
        const indexUrl = "{{ trim(route('admin.user.index', ['userId' => $userId]), '0123456789') }}";
        const userId = $('#userId').val();
        const userYm = $('#userYm').val();
        location.href= indexUrl + userId + '?user_ym=' + userYm;
    });
@endsection-->
--}}