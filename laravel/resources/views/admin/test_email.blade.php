@extends('layouts.admin')

@section('title', 'Test Email')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Test Email</h5>
            <p class="text-muted">Send a test email to verify your SMTP configuration is working correctly.</p>
            <form method="POST" action="{{ route('admin.email.test-send') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Recipient Email</label>
                    <input type="email" class="form-control @error('test_email') is-invalid @enderror" name="test_email" value="{{ old('test_email') }}" required>
                    @error('test_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Send Test Email</button>
            </form>
        </div>
    </div>

@endsection
