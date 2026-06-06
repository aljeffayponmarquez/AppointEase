@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<div class="auth-header">
    <div class="mb-2"><i class="bi bi-calendar-check-fill fs-1 text-white"></i></div>
    <h2>Welcome Back!</h2>
    <p>Sign in to your account</p>
</div>
<div class="auth-body">
    @if($errors->any())
    <div class="alert alert-danger py-2">
        @foreach($errors->all() as $error)
            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
        @endforeach
    </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="aljef@example.com" value="{{ old('email') }}" required autofocus>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Your password" required>
            </div>
        </div>
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>
    <div class="text-center mt-3">
        <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="fw-600 text-decoration-none">Register here</a></small>
    </div>
</div>
@endsection
