@extends('layouts.error')
@section('title', '存在しないページです')

@section('content')
<form>
    <div class="text-center mt-5">
        <h2>404 Not Found. このページは存在しません</h2>
    </div>
    <div class="text-center mt-5">
        <a class="btn btn-primary" href="/">TOPへ戻る</a>
    </div>
</form>
@endsection