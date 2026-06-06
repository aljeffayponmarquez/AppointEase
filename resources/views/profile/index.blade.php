@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body py-4">
                @php
                    $avatarUrl = $user->avatar && $user->avatar !== 'default.png'
                        ? asset('uploads/avatars/' . $user->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0ea5e9&color=fff&size=120';
                @endphp
                <div class="position-relative d-inline-block mb-3">
                    <img id="avatarPreview" src="{{ $avatarUrl }}" alt="Avatar"
                        style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:4px solid #0ea5e9">
                    <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width:30px;height:30px;cursor:pointer;">
                        <i class="bi bi-camera-fill" style="font-size:.8rem"></i>
                    </label>
                </div>
                <h5 class="mb-1 fw-700">{{ $user->name }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} mb-3">{{ ucfirst($user->role) }}</span>
                <div class="border-top pt-3 text-start">
                    <div class="small text-muted mb-1"><i class="bi bi-calendar3 me-2"></i>Joined {{ $user->created_at->format('F d, Y') }}</div>
                    @if($user->phone)<div class="small text-muted mb-1"><i class="bi bi-telephone me-2"></i>{{ $user->phone }}</div>@endif
                    @if($user->gender)<div class="small text-muted mb-1"><i class="bi bi-gender-ambiguous me-2"></i>{{ $user->gender }}</div>@endif
                    @if($user->address)<div class="small text-muted"><i class="bi bi-geo-alt me-2"></i>{{ $user->address }}</div>@endif
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatarForm">
            @csrf
            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
        </form>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-fill me-2 text-primary"></i>Edit Profile Information</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="09xx-xxx-xxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">-- Select --</option>
                                @foreach(['Male','Female','Other'] as $g)
                                <option value="{{ $g }}" {{ old('gender', $user->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h6 class="fw-700 mb-3"><i class="bi bi-lock-fill me-2 text-primary"></i>Change Password <span class="text-muted fw-400 small">(leave blank to keep)</span></h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-600">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Current password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('avatarInput').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { document.getElementById('avatarPreview').src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
            document.getElementById('avatarForm').submit();
        }
    });
</script>
@endpush
