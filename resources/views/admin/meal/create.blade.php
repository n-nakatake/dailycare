@extends('layouts.admin')
@section('title', '食事摂取量の登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>食事摂取量の登録</h2>
                <form action="{{ route('admin.meal.create', ['residentId->']) }}" method="post" enctype="multipart/form-data">

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
                            <select  class="form-control" name="meal_rocorder">
                                @foreach($users as $user)
                                    <option value="">選択してください</option>
                                    <option value="{{$user->id}}" {{ (int) old('meal_rocorder') === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>  
                                @endforeach
                            </select>
                            @if ($errors->has('meal_rocorder'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('meal_rocorder')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                        <label class="col-md-1">日時</label>
                        <div class="col-md-6">
                            <input type="datetime-local" class="form-control" name="meal_time" value="{{ old('meal_time') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">食事</label>
                        <div class="col-md-2">
                            <select  class="form-control" name="meal_bld">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('meal_bld') === '1' ? 'selected' : ''}}>朝食</option>
                                <option value="2" {{ old('meal_bld') === '2' ? 'selected' : ''}}>昼食</option>
                                <option value="3" {{ old('meal_bld') === '3' ? 'selected' : ''}}>晩食</option>
                            </select>
                            @if ($errors->has('meal_bld'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('meal_bld')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                        <label class="col-md-1">主食</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="meal_intake_rice" value="{{ old('meal_intake_rice') }}">
                        </div>
                        <label class="col-md-1">副食</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="meal_intake_side" value="{{ old('meal_intake_side') }}">
                        </div>
                        <label class="col-md-1">汁物</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="meal_intake_soup" value="{{ old('meal_intake_soup') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">特記</label>
                        <div class="col-md-11">
                            <textarea class="form-control" name="meal_note" rows="20">{{ old('meal_note') }}</textarea>
                        </div>
                    </div>
                    @csrf
                    <input type="submit" class="btn btn-primary" value="登録">
                </form>
            </div>
        </div>
    </div>
@endsection