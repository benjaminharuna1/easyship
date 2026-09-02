<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Testimonial;

class AboutController extends Controller
{
    public function __invoke()
    {
        $settings = Setting::find(1);
        $testimonials = Testimonial::where('is_published', 1)->orderBy('created_at', 'desc')->get();

        return view('about', compact('settings', 'testimonials'));
    }
}
