@extends('layouts.admin')
@section('title', 'ユーザー情報の編集')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if ($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        ユーザー情報の更新に失敗しました。
                    </div> 
                @endif
                <h2>ユーザー情報の編集</h2>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $userForm->id }}">
                            削除
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade text-dark" id="confirmModal{{ $userForm->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>{{ $userForm->last_name }}{{ $userForm->first_name }}さんのデータを削除してよろしいですか？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="button" class="btn btn-danger" onclick="location.href='{{ route('admin.user.delete', ['id' => $userForm->id]) }}'">削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="mt-5" action="{{ route('admin.user.update', [$userForm, $userForm->id]) }}" method="post" enctype="multipart/form-data">
 
                    <div class="form-group row">
                        <label class="w-10rem">氏名</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : $userForm->last_name }}">
                            @if ($errors->has('last_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('last_name')}}</strong>
                                </span>
                            @endif  
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : $userForm->first_name }}">
                            @if ($errors->has('first_name'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('first_name')}}</strong>
                                </span>
                            @endif                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="w-10rem">資格</label>
                        <div class="col-md-2">
                            <select  class="form-control" name="qualification">
                                <option value="">選択してください</option>
                                <option value="1" {{ old('qualification') ? (old('qualification') === '1' ? 'selected' : '') : ($userForm->qualification === '1' ? 'selected' : '')}}>介護福祉士</option>
                                <option value="2" {{ old('qualification') ? (old('qualification') === '2' ? 'selected' : '') : ($userForm->qualification === '2' ? 'selected' : '')}}>初任者研修修了</option>
                                <option value="3" {{ old('qualification') ? (old('qualification') === '3' ? 'selected' : '') : ($userForm->qualification === '3' ? 'selected' : '')}}>ヘルパー2級</option>
                                <option value="4" {{ old('qualification') ? (old('qualification') === '4' ? 'selected' : '') : ($userForm->qualification === '4' ? 'selected' : '')}}>ヘルパー1級</option>
                                <option value="5" {{ old('qualification') ? (old('qualification') === '5' ? 'selected' : '') : ($userForm->qualification === '5' ? 'selected' : '')}}>介護支援専門員</option>
                                <option value="6" {{ old('qualification') ? (old('qualification') === '6' ? 'selected' : '') : ($userForm->qualification === '6' ? 'selected' : '')}}>なし</option>
                            </select>
                            @if ($errors->has('qualification'))
                                <span class="small text-danger error-left">
                                　　<strong>{{$errors->first('qualification')}}</strong>
                                </span>
                            @endif                        
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <div class="checkbox w-10rem">
                            @if((( old('admin_flag') ? old('admin_flag') : $userForm->admin_flag )  == 1 ) || ( old('super_admin_flag') ? old('super_admin_flag') : $userForm->super_admin_flag ) == 1 )
                                <input type="checkbox" name="admin_flag" checked="checked">
                            @else
                                <input type="checkbox" name="admin_flag">
                            @endif
                            <label>管理者として登録</label>
                        </div>
                    </div>                        
                    <div class="form-group row">
                        <div class="checkbox w-10rem">
                            @if(( old('retirement_flag') ? old('retirement_flag') : $userForm->retirement_flag )  == 1 ) 
                                <input type="checkbox" name="retirement_flag" checked="checked">
                            @else
                                <input type="checkbox" name="retirement_flag">
                            @endif
                            <label>退職</label>
                        </div>
                        <div class="col-md-2">
                            <input type="date" min="1900-01-01" max="2200-12-31" class="form-control" name="retirement_day" value="{{ old('retirement_day') ? old('retirement_day') : $userForm->retirement_day }}">
                        </div>
                    </div>                        
                    @csrf
                    <div class="text-center mt-5">
                        <a class="col-md-3 btn btn-secondary me-5" href="{{ session('fromUrl') ? session('fromUrl') : route('admin.user.index') }}">キャンセル</a>
                        <input type="submit" class="btn btn-primary col-md-3" value="更新">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection