@extends('layouts.admin')
@section('title', '入居者の退所')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        入居者の退所に失敗しました。
                    </div> 
                @endif
                <h2>入居者の退所</h2>
                <form class="mt-5" action="{{ route('admin.resident.leave', ['residentId' => $resident->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">氏名</span></label>
                        <div class="col-md-3">{{ $resident->last_name }} {{ $resident->first_name }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">退所日<span class="half-size">※</span></label>
                        <div class="col-md-3">
                            @if ($resident->left_date && isPast($resident->left_date))
                                <p>{{ formatDateWithYear($resident->left_date) }}</p>
                            @else
                                <input type="date" min="2000-01-01" max="2200-12-31" class="form-control" name="left_date" value="{{ old('left_date') ? old('left_date') : getDateOnly($resident->left_date) }}">
                            @endif
                        </div>
                        @if ($errors->has('left_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('left_date') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class=col-md-3>退所理由 <span class="half-size">※</label>
                        <div class="col-md-9">
                            @if ($resident->left_date && isPast($resident->left_date))
                                <p>{!! nl2br(e($resident->leaving_note)) !!}</p>
                            @else
                                <textarea class="form-control" name="leaving_note" rows="5">{{ old('leaving_note') ? old('leaving_note') : $resident->leaving_note }}</textarea>
                            @endif
                        </div>                        
                        @if ($errors->has('leaving_note'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('leaving_note') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    @if ($resident->left_date && isPast($resident->left_date))
                        <div class="text-center mt-5">
                            <a class="col-md-3 btn btn-secondary me-5" href="{{ route('admin.resident.index') }}">戻る</a>
                        </div>
                    @else
                        <div class="form-group row">
                            <label class=offset-md-3><span class="half-size">※</span>入力必須</label>
                        </div>  
                        @csrf
                        <div class="text-center mt-5">
                            <a class="col-md-3 btn btn-secondary me-5" href="{{ route('admin.resident.index') }}">キャンセル</a>
                            <input type="submit" class="btn btn-danger col-md-3" value="退所">
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection