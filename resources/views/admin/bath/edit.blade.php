@extends('layouts.admin')
@section('title', '入浴状況の更新')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>入浴状況の編集</h2>
                <form action="{{ route('admin.bath.update',['residentId' => $bathForm->resident_id,'bathId' => $bathForm->id] ) }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <input type="hidden" name="resident_id" value="{{ $bathForm->resident_id }}">
                        <label class="col-md-1">記録者</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="user_id">
                                <option value="">選択してください</option>
                                @foreach($users as $user)
                                    <option value="{{$bathForm->user_id}}"
                                    @if (old('user_id'))
                                        {{ (int) old('user_id') === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>
                                    @else
                                        {{ $bathForm->user_id === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1">日時</label>
                        <div class="col-md-3">
                            <input type="datetime-local" class="form-control" name="bath_time" value="{{ old('bath_time') ? old('bath_time') : $bathForm->bath_time   }}">
                        </div>
                        <label class="col-md-1">方法</label>
                        <div class="col-md-3">
                            <select  class="form-control" name="bath_method">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('bath_method') === '1' ? 'selected' : ''}}>一般浴</option>
                                <option value="2" {{ old('bath_method') === '2' ? 'selected' : ''}}>シャワー浴</option>
                                <option value="3" {{ old('bath_method') === '3' ? 'selected' : ''}}>ストレッチャー浴</option>
                                <option value="4" {{ old('bath_method') === '4' ? 'selected' : ''}}>機械浴</option>
                                <option value="5" {{ old('bath_method') === '5' ? 'selected' : ''}}>清拭</option>
                                <option value="6" {{ old('bath_method') === '6' ? 'selected' : ''}}>陰洗</option>
                                <option value="7" {{ old('bath_method') === '7' ? 'selected' : ''}}>その他</option>
                            </select>
                            @if ($errors->has('bath_method'))
                        　　　　<span class="invalid-feedback">
                            　　<strong>{{$errors->first('bath_method')}}</strong>
                        　　　　</span>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">特記</label>
                        <div class="col-md-11">
                            <textarea class="form-control" name="bath_note" rows="20">{{ old('bath_note') }}</textarea>
                        </div>
                    </div>

                    @csrf
                    <input type="submit" class="btn btn-primary" value="更新">
                    
                    <!--<input type="submit" class="col-md-4 btn btn-primary"  value="更新">-->

                </form>
            </div>
        </div>
    </div>




@endsection