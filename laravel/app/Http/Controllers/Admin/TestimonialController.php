<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        return view('admin.testimonials', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'review_text' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'review_text' => $validated['review_text'],
            'rating' => $validated['rating'],
            'image' => $this->uploadImage($request),
            'is_published' => $request->boolean('is_published'),
        ]);

        session()->flash('success_message', 'Testimonial added successfully.');
        return redirect()->route('admin.testimonials.index');
    }

    public function edit(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.edit-testimonial', compact('testimonial'));
    }

    public function update(Request $request, int $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'review_text' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $image = $request->input('current_image', $testimonial->image);
        if ($request->hasFile('image')) {
            $this->deleteImage($image);
            $image = $this->uploadImage($request);
        }

        $testimonial->update([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'review_text' => $validated['review_text'],
            'rating' => $validated['rating'],
            'image' => $image,
            'is_published' => $request->boolean('is_published'),
        ]);

        session()->flash('success_message', 'Testimonial updated successfully.');
        return redirect()->route('admin.testimonials.index');
    }

    public function destroy(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $this->deleteImage($testimonial->image);
        $testimonial->delete();
        session()->flash('success_message', 'Testimonial deleted successfully.');
        return redirect()->route('admin.testimonials.index');
    }

    protected function uploadImage(Request $request): string
    {
        if (!$request->hasFile('image')) {
            return '';
        }
        $file = $request->file('image');
        $name = time() . '_' . basename($file->getClientOriginalName());
        $file->move(public_path('uploads'), $name);
        return 'uploads/' . $name;
    }

    protected function deleteImage(?string $path): void
    {
        if (!empty($path) && is_file(public_path($path))) {
            @unlink(public_path($path));
        }
    }
}
