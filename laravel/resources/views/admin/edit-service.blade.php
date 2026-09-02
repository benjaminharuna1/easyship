@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Service</h5>
            <form method="POST" action="{{ route('admin.services.update', $service->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $service->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon Class</label>
                    <input type="text" class="form-control" name="icon_class" value="{{ old('icon_class', $service->icon_class) }}" placeholder="e.g., icon-air-freight">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description', $service->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    @if($service->image)
                        <div class="mb-2"><img src="{{ asset($service->image) }}" style="max-width:200px;" class="rounded"></div>
                    @endif
                    <input type="file" class="form-control" name="image">
                    <input type="hidden" name="current_image" value="{{ $service->image }}">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ $service->is_published ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ $service->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured</label>
                </div>
                <button type="submit" class="btn btn-primary">Update Service</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
