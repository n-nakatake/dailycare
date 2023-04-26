@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('ユーザー登録') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            @if (Auth::user()->super_admin_flag)
                                <div class="form-group row">
                                    <label for="office_id" class="col-md-4 col-form-label text-md-right">事業所</label>
                                    <div class="col-md-6">
                                        <select  class="form-control" name="office_id">
                                            @foreach (App\Models\Office::all() as $office)
                                                <option value="{{ $office->id }}" {{ old('office_id') === $office->id ? 'selected' : ''}}>{{ $office->office_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('office_id'))
                                    　　　　<span class="invalid-feedback">
                                        　　<strong>{{$errors->first('office_id')}}</strong>
                                    　　　　</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('messages.last_name') }}</label>
    
                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
    
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('messages.first_name') }}</label>
    
                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
    
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="qualification" class="col-md-4 col-form-label text-md-right">{{ __('messages.q_info') }}</label>
                                <div class="col-md-6">
                                    <select  class="form-control" name="qualification">
                                        <option value="">選択してください</option>
                                        <option value="1" {{ old('qualification') === '1' ? 'selected' : ''}}>介護福祉士</option>
                                        <option value="2" {{ old('qualification') === '2' ? 'selected' : ''}}>初任者研修修了</option>
                                        <option value="3" {{ old('qualification') === '3' ? 'selected' : ''}}>ヘルパー2級</option>
                                        <option value="4" {{ old('qualification') === '4' ? 'selected' : ''}}>ヘルパー1級</option>
                                        <option value="5" {{ old('qualification') === '5' ? 'selected' : ''}}>介護支援専門員</option>
                                        <option value="6" {{ old('qualification') === '6' ? 'selected' : ''}}>なし</option>
                                    </select>
                                    @if ($errors->has('qualification'))
                                　　　　<span class="invalid-feedback">
                                    　　<strong>{{$errors->first('qualification')}}</strong>
                                　　　　</span>
                                    @endif 
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="user_code" class="col-md-4 col-form-label text-md-right">{{ __('messages.user_code') }}</label>
                                <div class="col-md-6">
                                    <input id="user_code" type="text" class="form-control @error('user_code') is-invalid @enderror" name="user_code" value="{{ old('user_code') }}" required autocomplete="user_code">
                                    @error('user_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('messages.password_again') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="admin_flag" {{ old('admin_flag') ? 'checked' : '' }}> 管理者として登録
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection