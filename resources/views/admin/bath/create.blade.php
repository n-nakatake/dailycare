@extends('layouts.admin')
@section('title', '入浴状況の登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        入浴状況の登録に失敗しました。
                    </div> 
                @endif
                <h2>入浴状況の登録</h2>
                <form class="mt-5" action="{{ route('admin.bath.create') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-5rem">利用者</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="resident_id">
                                @foreach($residents as $resident)
                                    <option value="{{$resident->id}}" 
                                        @if ((int) old('resident_id') > 0)
                                            {{ (int) old('resident_id') === $resident->id ? 'selected' : '' }}
                                        @elseif ($residentId === $resident->id)
                                            selected
                                        @endif
                                    >
                                        {{ $resident->last_name . $resident->first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1">様</label>
                        @if ($errors->has('resident_id'))
                            <span class="small text-danger error">
                            　　<strong>{{ $errors->first('resident_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">記録者</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                <option value="">選択してください</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (int) old('user_id') === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('user_id'))
                            <span class="small text-danger error">
                            　　<strong>{{ $errors->first('user_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">日時</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="bath_date" value=
                                 @if(old('bath_date'))
                                    "{{ old('bath_date') }}"
                                 @elseif(request()->input('date'))
                                    "{{ request()->input('date') }}"
                                 @else
                                    "{{ date("Y-m-d") }}"
                                 @endif
                            >
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="bath_time" value="{{ old('bath_time') ? old('bath_time') : date("H:i")}}">
                        </div>
                        @if ($errors->has('bath_date'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('bath_date')}}</strong>
                            </span>
                        @endif
                        @if ($errors->has('bath_time'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('bath_time')}}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">方法</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="bath_method">
                                <option value="">選択してください</option>
                                @foreach ($bathMethods as $id => $option)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('bath_method')))
                                            {{ (int) old('bath_method') === $id ? 'selected' : ''}}
                                        @endif
                                    >
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('bath_method'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('bath_method')}}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">特記</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="bath_note" rows="5">{{ old('bath_note') }}</textarea>
                        </div>
                    </div>
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.bath.index', ['residentId' => $residentId]) }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection