<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::orderBy('created_at', 'desc')->get();
        return view('admin.team', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        TeamMember::create([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'image' => $this->uploadImage($request),
            'is_published' => $request->boolean('is_published'),
        ]);

        session()->flash('success_message', 'Team member added successfully.');
        return redirect()->route('admin.team.index');
    }

    public function edit(int $id)
    {
        $member = TeamMember::findOrFail($id);
        return view('admin.edit-team', compact('member'));
    }

    public function update(Request $request, int $id)
    {
        $member = TeamMember::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'social_facebook' => ['nullable', 'url'],
            'social_twitter' => ['nullable', 'url'],
            'social_linkedin' => ['nullable', 'url'],
            'social_pinterest' => ['nullable', 'url'],
        ]);

        $image = $request->input('current_image', $member->image);
        if ($request->hasFile('image')) {
            $this->deleteImage($image);
            $image = $this->uploadImage($request);
        }

        $member->update([
            'name' => $validated['name'],
            'title' => $validated['title'],
            'image' => $image,
            'social_facebook' => $validated['social_facebook'] ?? null,
            'social_twitter' => $validated['social_twitter'] ?? null,
            'social_linkedin' => $validated['social_linkedin'] ?? null,
            'social_pinterest' => $validated['social_pinterest'] ?? null,
            'is_published' => $request->boolean('is_published'),
        ]);

        session()->flash('success_message', 'Team member updated successfully.');
        return redirect()->route('admin.team.index');
    }

    public function destroy(int $id)
    {
        $member = TeamMember::findOrFail($id);
        $this->deleteImage($member->image);
        $member->delete();
        session()->flash('success_message', 'Team member deleted successfully.');
        return redirect()->route('admin.team.index');
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
