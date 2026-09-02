<?php

namespace App\Http\Controllers;

use App\Models\Addtracking;
use App\Models\Setting;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        $settings = Setting::find(1);
        return view('track', compact('settings'));
    }

    public function results(Request $request)
    {
        $request->validate(['search_P' => ['required', 'string']]);

        $tracking = trim($request->input('search_P'));

        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])->where('tracking_id', $tracking)->first();

        if (!$shipment) {
            return back()->with('error', 'Tracking id Not Found');
        }

        return view('track-results', compact('shipment'));
    }
}
