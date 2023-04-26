@extends('layouts.admin')
@section('title', '入浴状況の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        入浴状況の更新に失敗しました。
                    </div> 
                @endif
                <h2>入浴状況の編集</h2>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $bathForm->id }}">
                            削除
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $bathForm->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ formatDatetime($bathForm->bath_time) }}のデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.bath.delete', ['residentId' => $bathForm->resident_id,'bathId' => $bathForm->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.bath.update', ['residentId' => $bathForm->resident_id, 'bathId' => $bathForm->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">利用者</label>
                        <div class="col-md-4">
                            {{ $bathForm->resident->last_name . $bathForm->resident->first_name }} 様
                        </div>
                        <input type="hidden" name="resident_id" value="{{ $bathForm->resident_id }}">
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">記録者</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        @if (old('user_id') > 0)
                                            {{ (int) old('user_id') === $user->id ? 'selected' : ''}}
                                        @elseif ($bathForm->user_id === $user->id)
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
                        <label class="col-md-3">日時 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="bath_date" value="{{ old('bath_date') ? old('bath_date') : substr($bathForm->bath_time, 0, 10) }}">
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="bath_time" value="{{ old('bath_time') ? old('bath_time') : substr($bathForm->bath_time, 11, 5) }}">
                        </div>
                        @if ($errors->has('bath_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('bath_date') }}</strong>
                                </span>
                            </div>
                        @endif
                        @if ($errors->has('bath_time'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('bath_time') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">方法 <span class="half-size">※</span></label>
                        <div class="col-md-5">
                            <select  class="form-control" name="bath_method">
                                @foreach ($bathMethods as $id => $name)
                                    <option value="{{ $id }}"
                                        @if (!empty(old('bath_method')))
                                            {{ (int) old('bath_method') === $id ? 'selected' : ''}}
                                        @elseif ((int) $bathForm->bath_method === $id)
                                            selected
                                        @endif
                                    >
                                        {{ $name }}
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
                        <label class="col-md-3">特記</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="bath_note" rows="5">{{ old('bath_note') ? old('bath_note') : $bathForm->bath_note }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class=offset-md-3><span class="half-size">※</span>入力必須</label>
                    </div>  
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.bath.index', ['residentId' => $bathForm->resident_id]) }}">キャンセル</a>
                        <input type="submit" class="col-md-3 btn btn-primary" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection