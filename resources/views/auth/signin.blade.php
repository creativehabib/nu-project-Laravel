@extends('layouts.base', ['subtitle' => 'Sign In'])

@section('body-attribute')
class="authentication-bg"
@endsection

@section('content')
<div class="account-pages">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="fw-bold text-dark mb-2">Welcome Back!</h3>
                                <p class="text-muted">Sign in to your account to continue</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}" class="mt-4">

                            @csrf

                            @if (sizeof($errors) > 0)
                            @foreach ($errors->all() as $error)
                            <p class="text-red-600 mb-3">{{ $error }}</p>
                            @endforeach
                            @endif

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" value="{{ old('email')}}" name="email" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password" class="form-label">Password</label>
                                    <a href="{{ route ('login') }}" class="text-decoration-none small text-muted">Forgot password?</a>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                            </div>
                            <div class="flex-box justify-content-between mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember-me">
                                    <label class="form-check-label" for="remember-me">Remember me</label>
                                </div>
                                <div>
                                    <a href="">Signup</a>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-dark btn-lg fw-medium" type="submit">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
