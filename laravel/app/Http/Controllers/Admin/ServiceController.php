<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('admin.services', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'icon_class' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,svg', 'max:2048'],
        ]);

        $image = $this->uploadImage($request);
        Service::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon_class' => $validated['icon_class'] ?? null,
            'image' => $image,
            'is_published' => $request->boolean('is_published'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        session()->flash('success_message', 'Service added successfully.');
        return redirect()->route('admin.services.index');
    }

    public function edit(int $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.edit-service', compact('service'));
    }

    public function update(Request $request, int $id)
    {
        $service = Service::findOrFail($id);
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'icon_class' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,svg', 'max:2048'],
        ]);

        $image = $request->input('current_image', $service->image);
        if ($request->hasFile('image')) {
            $this->deleteImage($image);
            $image = $this->uploadImage($request);
        }

        $service->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon_class' => $validated['icon_class'] ?? null,
            'image' => $image,
            'is_published' => $request->boolean('is_published'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        session()->flash('success_message', 'Service updated successfully.');
        return redirect()->route('admin.services.index');
    }

    public function destroy(int $id)
    {
        $service = Service::findOrFail($id);
        $this->deleteImage($service->image);
        $service->delete();
        session()->flash('success_message', 'Service deleted successfully.');
        return redirect()->route('admin.services.index');
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
