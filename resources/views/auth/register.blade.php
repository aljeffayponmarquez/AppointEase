@extends('layouts.auth')
@section('title', 'Register')

@section('content')
<div class="auth-header">
    <div class="mb-2"><i class="bi bi-calendar-check-fill fs-1 text-white"></i></div>
    <h2>Create Account</h2>
    <p>Join AppointmentScheduler today</p>
</div>
<div class="auth-body">
    @if($errors->any())
    <div class="alert alert-danger py-2">
        @foreach($errors->all() as $error)
            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
        @endforeach
    </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Aljef Dela Sosa" value="{{ old('name') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="aljef@example.com" value="{{ old('email') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-person-plus-fill me-2"></i>Register
        </button>
    </form>
    <div class="text-center mt-3">
        <small class="text-muted">Already have an account? <a href="{{ route('login') }}" class="fw-600 text-decoration-none">Sign In</a></small>
    </div>
</div>
@endsection
