@extends('layouts.admin')
@section('title', '登録済みの入浴状況一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>入浴状況一覧</h2>
        </div>

        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('admin.bath.add', ['residentId' => $residentId]) }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-9">
                <form action="{{ route('admin.bath.index', ['residentId' => $residentId]) }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-1">名前</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="resident_id">
                                @foreach($residents as $resident)
                                    <option value="{{$resident->id}}" {{ (int)$residentId === $resident->id ? 'selected' : ''}}>{{ $resident->last_name . $resident->first_name }}</option>  
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1"></label>
                        <label class="col-md-1">表示月</label>
                        <div class="col-md-3">
                            <input type="month" class="form-control" name="bath_ym" value="{{ $date }}">
                        </div>
                        <div class="col-md-1">
                            <input type="submit" class="btn btn-primary" value="更新">
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
                                <th width="10%">日付</th>
                                <th width="30%">時間</th>
                                <th width="40%">入浴方法</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($baths as $bath)
                                @php
                                    $bathCount = count($bath);
                                @endphp
                                @if($bathCount === 1 )
                                    <tr>
                                        <td>{{ str_split($bath[0]->bath_time, 10)[0] }}</td>
                                        <td>{{ str_split($bath[0]->bath_time, 10)[1] }}</td>
                                        <td>{{ $bath[0]->bath_method}}</td>
                                        <td>
                                            <div>
                                                <a href="{{ route('admin.bath.edit', ['residentId' => $bath[0]->resident_id,'bathId' =>  $bath[0]->id]) }}">編集</a>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.bath.delete', ['residentId' => $bath[0]->resident_id,'bathId' =>  $bath[0]->id]) }}">削除</a>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($bath as $bathTime)
                                        <tr>
                                            @if ($loop->first)
                                                <!--<td rowspan="$bathCount">str_split($bathTime->bath_time, 10)[0] </td>-->
                                                <td rowspan={{$bathCount}}>{{str_split($bathTime->bath_time, 10)[0]}}
                                                </td>
                                            @endif
                                            <td>{{ str_split($bathTime->bath_time, 10)[1] }}</td>
                                            <td>{{ $bathTime->bath_method}}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('admin.bath.edit', ['residentId' => $bathTime->resident_id,'bathId' => $bathTime->id]) }}">編集</a>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.bath.delete', ['residentId' => $bathTime->resident_id,'bathId' => $bathTime->id]) }}">削除</a>
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