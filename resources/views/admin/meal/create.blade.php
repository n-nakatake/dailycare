@extends('layouts.admin')
@section('title', '食事摂取量の登録')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        食事摂取量の登録に失敗しました。
                    </div> 
                @endif
                <h2>食事摂取量の登録</h2>
                <form class="mt-5" action="{{ route('admin.meal.create') }}" method="post" enctype="multipart/form-data">
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
                            <input type="date" class="form-control" name="meal_date" value=
                                 @if(old('meal_date'))
                                    "{{ old('meal_date') }}"
                                 @elseif(request()->input('date'))
                                    "{{ request()->input('date') }}"
                                 @else
                                    "{{ date("Y-m-d") }}"
                                 @endif
                            >
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="meal_time" value="{{ old('meal_time') ? old('meal_time') : date("H:i")}}">
                        </div>
                        @if ($errors->has('meal_date'))
                            <span class="small text-danger error">
                            　　<strong>{!! $errors->first('meal_date') !!}</strong>
                            </span>
                        @endif
                        @if ($errors->has('meal_time'))
                            <span class="small text-danger error">
                            　　<strong>{{ $errors->first('meal_time') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">食事</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="meal_bld">
                                <option value="">選択してください</option>
                                @foreach ($mealBldOptions as $id => $option)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_bld')))
                                            {{ (int) old('meal_bld') === $id ? 'selected' : ''}}
                                        @elseif(request()->input('meal_bld'))
                                            {{ (int) request()->input('meal_bld') === $id ? 'selected' : ''}}
                                        @endif
                                    >
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('meal_bld'))
                    　　　　<span class="small text-danger error">
                            　　<strong>{!! $errors->first('meal_bld') !!}</strong>
                    　　　　</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">主食</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="meal_intake_rice">
                                @foreach ($mealIntakeOptions as $id => $option)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_intake_rice')))
                                            {{ (int) old('meal_intake_rice') === $id ? 'selected' : ''}}
                                        @endif
                                    >
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('meal_intake_rice'))
                    　　　　<span class="small text-danger error">
                            　　<strong>{{ $errors->first('meal_intake_rice') }}</strong>
                    　　　　</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">副食</label>
                        <div class="col-md-3">
                             <select  class="form-control" name="meal_intake_side">
                                @foreach ($mealIntakeOptions as $id => $name)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_intake_side')))
                                            {{ (int) old('meal_intake_side') === $id ? 'selected' : ''}}
                                        @endif
                                    >
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                       </div>
                        @if ($errors->has('meal_intake_side'))
                    　　　　<span class="small text-danger error">
                            　　<strong>{{ $errors->first('meal_intake_side') }}</strong>
                    　　　　</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">汁物</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="meal_intake_soup">
                                @foreach ($mealIntakeOptions as $id => $name)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_intake_soup')))
                                            {{ (int) old('meal_intake_soup') === $id ? 'selected' : ''}}
                                        @endif
                                    >
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('meal_intake_soup'))
                    　　　　<span class="small text-danger error">
                            　　<strong>{{ $errors->first('meal_intake_soup') }}</strong>
                    　　　　</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">特記</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="meal_note" rows="5">{{ old('meal_note') }}</textarea>
                        </div>
                        @if ($errors->has('meal_note'))
                    　　　　<span class="small text-danger error">
                            　　<strong>{{ $errors->first('meal_note') }}</strong>
                    　　　　</span>
                        @endif                        
                    </div>
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.meal.index', ['residentId' => $residentId]) }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="登録">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection