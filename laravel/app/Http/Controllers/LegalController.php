<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use App\Models\Setting;

class LegalController extends Controller
{
    public function terms()
    {
        return $this->show('terms-and-conditions', 'Terms & Conditions');
    }

    public function privacy()
    {
        return $this->show('privacy-policy', 'Privacy Policy');
    }

    protected function show(string $slug, string $fallbackTitle)
    {
        $settings = Setting::find(1);
        $page = LegalPage::where('page_slug', $slug)->first()
            ?? new LegalPage(['page_title' => $fallbackTitle, 'page_content' => 'Content not available.']);

        $page->page_content = process_shortcodes($page->page_content);

        $title = $page->page_title;

        return view('legal', compact('settings', 'page', 'title'));
    }
}
