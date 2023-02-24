@extends('layouts.admin')
@section('title', 'vitalの編集')

@section('content')
    <div class="container">
        <div class="row">       
            <div class="col-md-8 mx-auto">
                <h2>vital編集</h2>
                <form action="{{ route('admin.vital.update',['residentId' => $vitalForm->resident_id,'vitalId' => $vitalForm->id] ) }}" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="w-5rem">利用者</label>
                        <div class="col-md-4">
                            {{ $vitalForm->resident->last_name . $vitalForm->resident->first_name }} 様
                        </div>
                        <input type="hidden" name="resident_id" value="{{ $vitalForm->resident_id }}">
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="resident_id" value="{{ $vitalForm->resident_id }}">
                        <label class="col-md-1">記録者</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="user_id">
                                <option value="">選択してください</option>
                                @foreach($users as $user)
                                    <option value="{{$vitalForm->user_id}}"
                                    @if (old('user_id'))
                                        {{ (int) old('user_id') === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>
                                    @else
                                        {{ $vitalForm->user_id === $user->id ? 'selected' : ''}}>{{ $user->last_name . $user->first_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-1">日時</label>
                        <div class="col-md-6">
                            <input type="datetime-local" class="form-control" name="vital_time" value="{{ old('vital_time') ? old('vital_time') : $vitalForm->vital_time   }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-1">体温</label>
                        <div class="col-md-2">
                            <input type="number" step="0.1" class="form-control" name="vital_kt" value="{{ old('vital_kt') ? old('vital_kt') : $vitalForm->vital_kt   }}">
                        </div>
                        <label class="col-md-1">血圧</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_u" value="{{ old('vital_bp_u') ? old('vital_bp_u') : $vitalForm->vital_bp_u   }}">
                        </div>
                        <label class="col-md-1">／</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_bp_d" value="{{ old('vital_bp_d') ? old('vital_bp_d') : $vitalForm->vital_bp_d   }}">
                        </div>
                        <label class="col-md-1">心拍数</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_hr" value="{{ old('vital_hr') ? old('vital_hr') : $vitalForm->vital_hr   }}">
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">身長</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_height" value="{{ old('vital_height') ? old('vital_height') : $vitalForm->vital_height   }}">
                        </div>
                        <label class="col-md-1">体重</label>
                        <div class="col-md-2">
                            <input type="text" inputmode="numeric" pattern="\d*" class="form-control" name="vital_weight" value="{{ old('vital_weight') ? old('vital_weight') : $vitalForm->vital_weight   }}">
                        </div>                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">特記</label>
                        <div class="col-md-11">
                            <textarea class="form-control" name="vital_note" rows="20">{{ old('vital_note') ? old('vital_note') : $vitalForm->vital_note }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1">画像</label>
                        <div class="col-md-11">
                            <input type="file" class="form-control-file" name="vital_image_path">
                        </div>
                    </div>
                    @csrf
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
                <div class="row mt-5">
                    <div class="col-md-4 mx-auto">
                        <h2>編集履歴</h2>
                        <ul class="list-group">
                            @if ($vitalForm->histories != NULL)
                                @foreach ($vitalForm->histories as $history)
                                    <li class="list-group-item">{{ $history->edited_at }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection