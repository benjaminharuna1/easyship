@extends('layouts.admin')

@section('title', 'Edit Testimonial')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Edit Testimonial</h5>
            <form method="POST" action="{{ route('admin.testimonials.update', $testimonial->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $testimonial->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $testimonial->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select class="form-control" name="rating" required>
                        @for($r = 1; $r <= 5; $r++)
                            <option value="{{ $r }}" {{ old('rating', $testimonial->rating) == $r ? 'selected' : '' }}>{{ $r }} Star{{ $r > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Review Text</label>
                    <textarea class="form-control @error('review_text') is-invalid @enderror" name="review_text" rows="4" required>{{ old('review_text', $testimonial->review_text) }}</textarea>
                    @error('review_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    @if($testimonial->image)
                        <div class="mb-2"><img src="{{ asset($testimonial->image) }}" style="max-width:150px;" class="rounded-circle"></div>
                    @endif
                    <input type="file" class="form-control" name="image">
                    <input type="hidden" name="current_image" value="{{ $testimonial->image }}">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ $testimonial->is_published ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Testimonial</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection
