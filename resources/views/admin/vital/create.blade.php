@extends('layouts.admin')
@section('title', 'vitalの新規登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>vital新規登録</h2>
                <form action="{{ route('admin.vital.create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-1">利用者</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="resident_id">
                                @foreach($residents as $resident)
                                    <option value="{{$residentId}}">{{$residentName}}</option>
                                    <option value="{{$resident->id}}" {{ (int) old('resident_id') === $resident->id ? 'selected' : ''}}>{{ $resident->last_name . $resident->first_name }}</option>  
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1">様</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">記録者</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="vital_rocorder">
                                @foreach($users as $user)
                                    <option value="">選択してください</option>
                                    <option value="{{$user->id}}" {{ (int) old('vital_rocorder') === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>  
                                @endforeach
                            </select>
                            @if ($errors->has('vital_rocorder'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('vital_rocorder')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                        <label class="col-md-1">日時</label>
                        <div class="col-md-6">
                            <input type="datetime-local" class="form-control" name="vital_time" value="{{ old('vital_time') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">体温</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_kt" value="{{ old('vital_kt') }}">
                        </div>
                        <label class="col-md-1">血圧</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_u" value="{{ old('vital_bp_u') }}">
                        </div>
                        <label class="col-md-1">／</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_d" value="{{ old('vital_bp_d') }}">
                        </div>
                        <label class="col-md-1">心拍数</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_hr" value="{{ old('vital_hr') }}">
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">身長</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_height" value="{{ old('vital_height') }}">
                        </div>
                        <label class="col-md-1">体重</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_weight" value="{{ old('vital_weight') }}">
                        </div>                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">特記</label>
                        <div class="col-md-11">
                            <textarea class="form-control" name="vital_note" rows="20">{{ old('vital_note') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">画像</label>
                        <div class="col-md-11">
                            <input type="file" class="form-control-file" name="vital_image_path">
                        </div>
                    </div>
                    @csrf
                    <input type="submit" class="btn btn-primary" value="登録">
                </form>
            </div>
        </div>
    </div>
@endsection