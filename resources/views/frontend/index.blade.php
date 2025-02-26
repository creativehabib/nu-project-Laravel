@extends('layouts.base', ['subtitle' => 'Home'])

@section('body-attribute')
    class="authentication-bg"
@endsection

@section('content')
    <div class="flex-box flex-column">
        <h1 class="align-items-center align-content-center">National University</h1>
        <div>
            <a class="btn btn-sm btn-primary" href="{{ route('login') }}">Login</a>
        </div>
    </div>
@endsection
