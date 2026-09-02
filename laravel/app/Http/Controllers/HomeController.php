<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function __invoke()
    {
        $settings = Setting::find(1);
        $featuredServices = Service::where('is_published', 1)
            ->where('is_featured', 1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $testimonials = Testimonial::where('is_published', 1)->orderBy('created_at', 'desc')->get();
        $teamMembers = TeamMember::where('is_published', 1)->orderBy('created_at', 'desc')->get();

        return view('home', compact('settings', 'featuredServices', 'testimonials', 'teamMembers'));
    }
}
