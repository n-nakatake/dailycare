@extends('layouts.admin')
@section('title', 'TOP')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div> 
                @endif
                <h2>TOP</h2>
            </div>
        </div>
    </div>
@endsection