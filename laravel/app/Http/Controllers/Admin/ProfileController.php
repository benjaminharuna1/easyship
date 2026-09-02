<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.admin-profile', compact('admin'));
    }

    public function editForm()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.edit-admin', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'email' => ['required', 'email', 'unique:admin,email,' . $admin->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $admin->email = $request->email;
        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        session()->flash('success_message', 'Profile updated successfully.');
        return redirect()->route('admin.profile');
    }
}
