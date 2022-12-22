@extends('layouts.admin')
@section('title', '登録済みのvital一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>vital一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('admin.vital.add', ['residentId' => $residentId]) }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-9">
                <form action="{{ route('admin.vital.index', ['residentId' => $residentId]) }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-1">名前</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="resident_id">
                                @foreach($residents as $resident)
                                    <option value="{{$resident->id}}" {{ $residentId === $resident->id ? 'selected' : ''}}>{{ $resident->last_name . $resident->first_name }}</option>  
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1"></label>
                        <label class="col-md-1">表示月</label>
                        <div class="col-md-3">
                            <input type="month" class="form-control" name="vital_ym" value="{{ $date }}">
                        </div>
                        <div class="col-md-1">
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-vital col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">日付</th>
                                <th width="20%">時間</th>
                                <th width="20%">体温</th>
                                <th width="20%">血圧（上）</th>
                                <th width="20%">血圧（下）</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vitals as $vital)
                                @php
                                    $vitalCount = count($vital);
                                @endphp
                                @if($vitalCount === 1 )
                                    <tr>
                                        <td>{{ str_split($vital[0]->vital_time, 10)[0] }}</td>
                                        <td>{{ str_split($vital[0]->vital_time, 10)[1] }}</td>
                                        <td>{{ $vital[0]->vital_kt}}</td>
                                        <td>{{ $vital[0]->vital_bp_u}}</td>
                                        <td>{{ $vital[0]->vital_bp_d}}</td>
                                        <td>
                                            <div>
                                                <a href="{{ route('admin.vital.edit', ['residentId' => $vital[0]->resident_id,'vitalId' =>  $vital[0]->id]) }}">編集</a>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.vital.delete', ['residentId' => $vital[0]->resident_id,'vitalId' =>  $vital[0]->id]) }}">削除</a>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($vital as $vitalTime)
                                        <tr>
                                            @if ($loop->first)
                                                <!--<td rowspan="$vitalCount">str_split($vitalTime->vital_time, 10)[0] </td>-->
                                                <td rowspan={{$vitalCount}}>{{str_split($vitalTime->vital_time, 10)[0]}}
                                                </td>
                                            @endif
                                            <td>{{ str_split($vitalTime->vital_time, 10)[1] }}</td>
                                            <td>{{ $vitalTime->vital_kt}}</td>
                                            <td>{{ $vitalTime->vital_bp_u}}</td>
                                            <td>{{ $vitalTime->vital_bp_d}}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('admin.vital.edit', ['residentId' => $vitalTime->resident_id,'vitalId' => $vitalTime->id]) }}">編集</a>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.vital.delete', ['residentId' => $vitalTime->resident_id,'vitalId' => $vitalTime->id]) }}">削除</a>
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