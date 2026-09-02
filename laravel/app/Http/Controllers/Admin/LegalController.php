<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function index()
    {
        $terms = LegalPage::firstOrCreate(
            ['page_slug' => 'terms-and-conditions'],
            ['page_title' => 'Terms & Conditions', 'page_content' => '']
        );
        $privacy = LegalPage::firstOrCreate(
            ['page_slug' => 'privacy-policy'],
            ['page_title' => 'Privacy Policy', 'page_content' => '']
        );

        return view('admin.legal', compact('terms', 'privacy'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'terms_title' => ['required', 'string'],
            'terms_content' => ['nullable', 'string'],
            'privacy_title' => ['required', 'string'],
            'privacy_content' => ['nullable', 'string'],
        ]);

        LegalPage::updateOrCreate(
            ['page_slug' => 'terms-and-conditions'],
            ['page_title' => $validated['terms_title'], 'page_content' => $validated['terms_content']]
        );
        LegalPage::updateOrCreate(
            ['page_slug' => 'privacy-policy'],
            ['page_title' => $validated['privacy_title'], 'page_content' => $validated['privacy_content']]
        );

        session()->flash('success_message', 'Page content updated successfully.');
        return redirect()->route('admin.legal');
    }
}
