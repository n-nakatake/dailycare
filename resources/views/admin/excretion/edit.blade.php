@extends('layouts.admin')
@section('title', '排泄状況の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        排泄状況の更新に失敗しました。
                    </div> 
                @endif
                <h2>排泄状況の編集</h2>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $excretionForm->id }}">
                            削除
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $excretionForm->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ formatDatetime($excretionForm->excretion_time) }}のデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.excretion.delete', ['residentId' => $excretionForm->resident_id,'excretionId' => $excretionForm->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.excretion.update', ['residentId' => $excretionForm->resident_id, 'excretionId' => $excretionForm->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-5rem">利用者</label>
                        <div class="col-md-4">
                            {{ $excretionForm->resident->last_name . $excretionForm->resident->first_name }} 様
                        </div>
                        <input type="hidden" name="resident_id" value="{{ $excretionForm->resident_id }}">
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">記録者</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        @if (old('user_id') > 0)
                                            {{ (int) old('user_id') === $user->id ? 'selected' : ''}}
                                        @elseif ($excretionForm->user_id === $user->id)
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
                            <input type="date" class="form-control" name="excretion_date" value="{{ old('excretion_date') ? old('excretion_date') : substr($excretionForm->excretion_time, 0, 10) }}">
                        </div>
                        <div class="col-md-3">
                            <input type="time" class="form-control" name="excretion_time" value="{{ old('excretion_time') ? old('excretion_time') : substr($excretionForm->excretion_time, 11, 5) }}">
                        </div>
                        @if ($errors->has('excretion_date'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('excretion_date')}}</strong>
                            </span>
                        @endif
                        @if ($errors->has('excretion_time'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('excretion_time')}}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class="w-5rem">状況</label>
                        <div class="col-md-2">
                            <span>
                            @if(( old('excretion_flash') ? old('excretion_flash') : $excretionForm->excretion_flash )  == 1 ) 
                                <input type="checkbox" name="excretion_flash" checked="checked">
                            @else
                                <input type="checkbox" name="excretion_flash">
                            @endif
                            <label>排尿</label>
                            </span>
                        </div>
                        <div class="col-md-2">
                            <span>
                            @if( $excretionForm->excretion_dump == 1 ) 
                                <input type="checkbox" name="excretion_dump" checked="checked">
                            @else
                                 <input type="checkbox" name="excretion_dump">
                            @endif
                            </span>
                            <label>排便</label>
                        </div>
                        
                        @if ($errors->has('excretion_flash'))
                            <span class="small text-danger error">
                            　　<strong>{{$errors->first('excretion_flash')}}</strong>
                            </span>
                        @endif                        
                    </div>    

                    <div class="form-group row">
                        <label class="w-5rem">特記</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="excretion_note" rows="5">{{ old('excretion_note') ? old('excretion_note') : $excretionForm->excretion_note }}</textarea>
                        </div>
                    </div>
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.excretion.index', ['residentId' => $excretionForm->resident_id]) }}">キャンセル</a>
                        <input type="submit" class="col-md-3 btn btn-primary" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection