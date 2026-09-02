<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;

class ServicesController extends Controller
{
    public function __invoke()
    {
        $settings = Setting::find(1);
        $services = Service::where('is_published', 1)->orderBy('created_at', 'desc')->get();

        return view('services', compact('settings', 'services'));
    }
}
