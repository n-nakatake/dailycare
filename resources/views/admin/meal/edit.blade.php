@extends('layouts.admin')
@section('title', '食事摂取量の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        食事摂取量の更新に失敗しました。
                    </div> 
                @endif
                <h2>食事摂取量の編集</h2>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $mealForm->id }}">
                            削除
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $mealForm->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ formatDate($mealForm->meal_time) }}の{{ $mealBldOptions[$mealForm->meal_bld] }}のデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.meal.delete', ['residentId' => $mealForm->resident_id,'mealId' => $mealForm->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.meal.update',['residentId' => $mealForm->resident_id, 'mealId' => $mealForm->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-5rem">利用者</label>
                        <div class="col-md-4">
                            {{ $mealForm->resident->last_name . $mealForm->resident->first_name }} 様
                        </div>
                        <input type="hidden" name="resident_id" value="{{ $mealForm->resident_id }}">
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">記録者</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        @if (old('user_id') > 0)
                                            {{ (int) old('user_id') === $user->id ? 'selected' : ''}}
                                        @elseif ($mealForm->user_id === $user->id)
                                            selected
                                        @endif
                                    >
                                        {{ $user->last_name . $user->first_name }}
                                    </option>
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
                            <input type="date" class="form-control" name="meal_date" value="{{ old('meal_date') ? old('meal_date') : substr($mealForm->meal_time, 0, 10) }}">
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="meal_time" value="{{ old('meal_time') ? old('meal_time') : substr($mealForm->meal_time, 11, 5) }}">
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
                                @foreach ($mealBldOptions as $id => $option)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_bld')))
                                            {{ (int) old('meal_bld') === $id ? 'selected' : ''}}
                                        @elseif ((int) $mealForm->meal_bld === $id)
                                            selected
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
                                <option value="">選択してください</option>
                                @foreach ($mealIntakeOptions as $id => $name)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_intake_rice')))
                                            {{ (int) old('meal_intake_rice') === $id ? 'selected' : ''}}
                                        @elseif ((int) $mealForm->meal_intake_rice === $id)
                                            selected
                                        @endif
                                    >
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('meal_intake_rice'))
                        　　　　<span class="small text-danger error">
                                　　<strong>{{ $errors->first('meal_intake_rice') }}</strong>
                        　　　　</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">副食</label>
                        <div class="col-md-3">
                             <select  class="form-control" name="meal_intake_side">
                                <option value="">選択してください</option>
                                @foreach ($mealIntakeOptions as $id => $name)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_intake_side')))
                                            {{ (int) old('meal_intake_side') === $id ? 'selected' : ''}}
                                        @elseif ((int) $mealForm->meal_intake_side === $id)
                                            selected
                                        @endif
                                    >
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('meal_intake_side'))
                        　　　　<span class="small text-danger error">
                                　　<strong>{{ $errors->first('meal_intake_side') }}</strong>
                        　　　　</span>
                            @endif
                       </div>
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">汁物</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="meal_intake_soup">
                                <option value="">選択してください</option>
                                @foreach ($mealIntakeOptions as $id => $name)
                                    <option value="{{ $id }}" 
                                        @if (!empty(old('meal_intake_soup')))
                                            {{ (int) old('meal_intake_soup') === $id ? 'selected' : ''}}
                                        @elseif ((int) $mealForm->meal_intake_soup === $id)
                                            selected
                                        @endif
                                    >
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('meal_intake_soup'))
                        　　　　<span class="small text-danger error">
                                　　<strong>{{ $errors->first('meal_intake_soup') }}</strong>
                        　　　　</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">特記</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="meal_note" rows="5">{{ old('meal_note') ? old('meal_note') : $mealForm->meal_note}}</textarea>
                        </div>
                        @if ($errors->has('meal_note'))
                    　　　　<span class="small text-danger error">
                            　　<strong>{{ $errors->first('meal_note') }}</strong>
                    　　　　</span>
                        @endif                        
                    </div>
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.meal.index', ['residentId' => $mealForm->resident_id]) }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection