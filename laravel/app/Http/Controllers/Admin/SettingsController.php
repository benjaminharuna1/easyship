<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::findOrNew(1);
        return view('admin.settings', compact('settings'));
    }

    public function updateSiteSettings(Request $request)
    {
        $validated = $request->validate([
            'site-name' => ['required', 'string'],
            'site-title' => ['required', 'string'],
            'site-url' => ['required', 'url'],
            'email-name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['nullable', 'string'],
            'fax_number' => ['nullable', 'string'],
            'site_address' => ['nullable', 'string'],
            'site_currency' => ['required', 'string'],
            'geocode_api_key' => ['nullable', 'string'],
            'working_days' => ['nullable', 'string'],
            'working_hours' => ['nullable', 'string'],
        ]);

        $settings = Setting::findOrFail(1);

        $settings->update([
            'sitename' => $validated['site-name'],
            'site_title' => $validated['site-title'],
            'site_url' => $validated['site-url'],
            'email_name' => $validated['email-name'],
            'email_address' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'fax_number' => $validated['fax_number'] ?? null,
            'site_address' => $validated['site_address'] ?? null,
            'site_currency' => $validated['site_currency'],
            'geocode_api_key' => $validated['geocode_api_key'] ?? null,
            'working_days' => $validated['working_days'] ?? null,
            'working_hours' => $validated['working_hours'] ?? null,
        ]);

        // Image upload/removal
        $imageFields = [
            'site-logo' => 'site_logo',
            'site-favicon' => 'site_favicon',
            'invoice-stamp' => 'invoice_stamp',
            'invoice-banner' => 'invoice_banner',
            'payment-methods-image' => 'payment_methods_image',
        ];

        foreach ($imageFields as $inputName => $column) {
            $current = $settings->{$column};

            if (!empty($request->input('remove_' . $column))) {
                $this->deleteImage($current);
                $settings->update([$column => '']);
            } elseif ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $filename = 'uploads/' . time() . '_' . basename($file->getClientOriginalName());
                $file->move(public_path('uploads'), basename($filename));
                $this->deleteImage($current);
                $settings->update([$column => $filename]);
            }
        }

        session()->flash('success_message', 'Site settings updated successfully.');
        return redirect()->route('admin.settings')->with('anchor', 'site-settings');
    }

    public function updateHomepageContent(Request $request)
    {
        $validated = $request->validate([
            'hero_subtitle' => ['nullable', 'string'],
            'hero_title' => ['nullable', 'string'],
            'hero_text' => ['nullable', 'string'],
            'years_experience' => ['nullable', 'integer'],
            'achievement_1_num' => ['nullable', 'integer'],
            'achievement_1_title' => ['nullable', 'string'],
            'achievement_2_num' => ['nullable', 'integer'],
            'achievement_2_title' => ['nullable', 'string'],
            'achievement_3_num' => ['nullable', 'integer'],
            'achievement_3_title' => ['nullable', 'string'],
            'achievement_4_num' => ['nullable', 'integer'],
            'achievement_4_suffix' => ['nullable', 'string'],
            'achievement_4_title' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url'],
        ]);

        $settings = Setting::findOrFail(1);

        $videoBgImage = $request->input('current_video_bg_image');
        if ($request->hasFile('video_bg_image')) {
            $file = $request->file('video_bg_image');
            $videoBgImage = 'uploads/' . time() . '_' . basename($file->getClientOriginalName());
            $file->move(public_path('uploads'), basename($videoBgImage));
        }

        $settings->update([
            'hero_subtitle' => $validated['hero_subtitle'] ?? null,
            'hero_title' => $validated['hero_title'] ?? null,
            'hero_text' => $validated['hero_text'] ?? null,
            'years_experience' => $validated['years_experience'] ?? 10,
            'achievement_1_num' => $validated['achievement_1_num'] ?? null,
            'achievement_1_title' => $validated['achievement_1_title'] ?? null,
            'achievement_2_num' => $validated['achievement_2_num'] ?? null,
            'achievement_2_title' => $validated['achievement_2_title'] ?? null,
            'achievement_3_num' => $validated['achievement_3_num'] ?? null,
            'achievement_3_title' => $validated['achievement_3_title'] ?? null,
            'achievement_4_num' => $validated['achievement_4_num'] ?? null,
            'achievement_4_suffix' => $validated['achievement_4_suffix'] ?? null,
            'achievement_4_title' => $validated['achievement_4_title'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'video_bg_image' => $videoBgImage,
        ]);

        session()->flash('success_message', 'Homepage content updated successfully.');
        return redirect()->route('admin.settings')->with('anchor', 'homepage-content');
    }

    public function updateEmailSettings(Request $request)
    {
        $validated = $request->validate([
            'smtp-host' => ['required', 'string'],
            'smtp-username' => ['required', 'string'],
            'smtp-password' => ['nullable', 'string'],
            'smtp-port' => ['required', 'integer'],
            'smtp-secure' => ['nullable', 'string'],
        ]);

        $settings = Setting::findOrFail(1);
        $settings->update([
            'smtp_host' => $validated['smtp-host'],
            'smtp_username' => $validated['smtp-username'],
            'smtp_password' => $validated['smtp-password'] ?? $settings->smtp_password,
            'smtp_port' => $validated['smtp-port'],
            'smtp_secure' => $validated['smtp-secure'] ?? null,
        ]);

        session()->flash('success_message', 'Email settings updated successfully.');
        return redirect()->route('admin.settings')->with('anchor', 'email-settings');
    }

    public function updateGeneralSettings(Request $request)
    {
        $settings = Setting::findOrFail(1);
        $settings->update([
            'maintenance_mode' => $request->boolean('maintenance_mode'),
            'search_engine_indexing' => $request->boolean('search_engine_indexing'),
        ]);

        // Write robots.txt
        $robotsContent = $request->boolean('search_engine_indexing')
            ? "User-agent: *\nAllow: /"
            : "User-agent: *\nDisallow: /";
        file_put_contents(public_path('robots.txt'), $robotsContent);

        session()->flash('success_message', 'General settings updated successfully.');
        return redirect()->route('admin.settings')->with('anchor', 'general-settings');
    }

    protected function deleteImage(?string $path): void
    {
        if (!empty($path) && is_file(public_path($path))) {
            @unlink(public_path($path));
        }
    }
}
