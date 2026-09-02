@extends('layouts.admin')

@section('title', 'Edit Team Member')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Team Member</h5>
            <form method="POST" action="{{ route('admin.team.update', $member->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $member->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Title / Role</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $member->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    @if($member->image)
                        <div class="mb-2"><img src="{{ asset($member->image) }}" style="max-width:150px;" class="rounded-circle"></div>
                    @endif
                    <input type="file" class="form-control" name="image">
                    <input type="hidden" name="current_image" value="{{ $member->image }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" class="form-control" name="social_facebook" value="{{ old('social_facebook', $member->social_facebook) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" class="form-control" name="social_twitter" value="{{ old('social_twitter', $member->social_twitter) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" class="form-control" name="social_linkedin" value="{{ old('social_linkedin', $member->social_linkedin) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pinterest URL</label>
                        <input type="url" class="form-control" name="social_pinterest" value="{{ old('social_pinterest', $member->social_pinterest) }}">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ $member->is_published ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Member</button>
                <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
