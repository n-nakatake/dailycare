@extends('layouts.admin')
@section('title', 'ユーザーの退職')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        ユーザーの退職に失敗しました。
                    </div> 
                @endif
                <h2>ユーザーの退職</h2>
                <form class="mt-5" action="{{ route('admin.user.retire', ['userId' => $user->id]) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-md-3">氏名</label>
                        <div class="col-md-3">{{ $user->last_name }} {{ $user->first_name }}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">退職日 <span class="half-size">※</span></label>
                        <div class="col-md-3">
                            @if ($user->retirement_date && isPast($user->retirement_date))
                                <p>{{ formatDateWithYear($user->retirement_date) }}</p>
                            @else
                                <input type="date" min="2000-01-01" max="2200-12-31" class="form-control" name="retirement_date" value="{{ old('retirement_date') ? old('retirement_date') : getDateOnly($user->retirement_date) }}">
                            @endif
                        </div>
                        @if ($errors->has('retirement_date'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('retirement_date') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label class=col-md-3>退職理由 <span class="half-size">※</label>
                        <div class="col-md-9">
                            @if ($user->retirement_date && isPast($user->retirement_date))
                                <p>{!! nl2br(e($user->retirement_note)) !!}</p>
                            @else
                                <textarea class="form-control" name="retirement_note" rows="5">{{ old('retirement_note') ? old('retirement_note') : $user->retirement_note }}</textarea>
                            @endif
                        </div>
                        @if ($errors->has('retirement_note'))
                            <div class="offset-md-3">
                                <span class="small text-danger error-left">
                                　　<strong>{{ $errors->first('retirement_note') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    @if ($user->retirement_date && isPast($user->retirement_date))
                        <div class="text-center mt-5">
                            <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.user.index') }}">戻る</a>
                        </div>
                    @else
                        <div class="form-group row">
                            <label class=offset-md-3><span class="half-size">※</span>入力必須</label>
                        </div>  
                        @csrf
                        <div class="text-center mt-5">
                            <a class="col-md-3 btn btn-secondary me-5" href="{{ route('admin.user.index') }}">キャンセル</a>
                            <input type="submit" class="btn btn-danger col-md-3" value="退職">
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection