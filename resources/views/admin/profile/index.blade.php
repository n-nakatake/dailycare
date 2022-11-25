@extends('layouts.admin')
@section('title', '登録済みのprofile一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>profile一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.profile.add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.profile.index') }}" method="get">
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
            <div class="list-profile col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">名前</th>
                                <th width="20%">性別</th>
                                <th width="20%">誕生日（年齢）</th>
                                <th width="20%">介護度</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profiles as $profile)
                                <tr>
                                    <th>{{ $profile->id }}</th>
                                    <td>{{ Str::limit($profile->resident_last_name, 100) }} {{ Str::limit($profile->resident_first_name, 100) }}</td>
                                    @if ($profile->resident_gender == 1 )
                                        <td>男性</td>
                                    @else
                                        <td>女性</td>
                                    @endif
                                    <td>{{toWareki('KX年m月d日', str_replace("-","",$profile->resident_birthday))}}</td>
                                    @if ($profile->resident_level == 1 )
                                        <td>要介護１</td>
                                    @elseif ($profile->resident_level == 2 )
                                        <td>要介護２</td>
                                    @elseif ($profile->resident_level == 3 )
                                        <td>要介護３</td>
                                    @elseif ($profile->resident_level == 4 )
                                        <td>要介護４</td>
                                    @elseif ($profile->resident_level == 5 )
                                        <td>要介護５</td>
                                    @elseif ($profile->resident_level == 6 )
                                        <td>要支援１</td>
                                    @elseif ($profile->resident_level == 7 )
                                        <td>要支援２</td>
                                    @elseif ($profile->resident_level == 8 )
                                        <td>該当なし</td>
                                    @endif                                      
                                    <td>
                                        <div>
                                            <a href="{{ route('admin.profile.edit', ['id' => $profile->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.profile.delete', ['id' => $profile->id]) }}">削除</a>
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