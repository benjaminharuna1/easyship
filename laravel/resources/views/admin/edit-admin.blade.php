@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Admin Profile</h5>
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $admin->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Leave blank to keep current password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="{{ route('admin.profile') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
