@extends('layouts.admin')

@section('title', 'Send Email')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Send Email</h5>
            <form method="POST" action="{{ route('admin.email.send') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Recipient Email</label>
                    <input type="email" class="form-control @error('recipient') is-invalid @enderror" name="recipient" value="{{ old('recipient') }}" required>
                    @error('recipient')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Message Body</label>
                    <textarea class="form-control js-summernote @error('body') is-invalid @enderror" name="body" rows="10" required>{{ old('body') }}</textarea>
                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Attachments (optional, multiple)</label>
                    <input type="file" class="form-control" name="attachments[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Send Email</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(function() { $('.js-summernote').summernote({ height: 250 }); });
</script>
@endpush
