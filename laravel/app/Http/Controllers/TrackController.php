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
        $title = 'Track Shipment';

        return view('track', compact('settings', 'title'));
    }

    public function results(Request $request)
    {
        $request->validate(['search_P' => ['required', 'string']]);

        $tracking = trim($request->input('search_P'));

        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])
            ->where('tracking_id', $tracking)
            ->first();

        if (!$shipment) {
            return back()->with('error', 'Tracking id Not Found');
        }

        $settings = Setting::find(1);
        $title = 'Tracking Shipment';

        $image_src = $shipment->image
            ? asset('uploads/' . $shipment->image)
            : 'https://placehold.co/330x150/EEE/31343C.png?text=Package';

        $shipment_history = $shipment->shipmentHistory
            ->map(function ($h) {
                return [
                    'location' => $h->location,
                    'date' => $h->date,
                    'time' => $h->time,
                    'remarks' => $h->remarks,
                    'status' => $h->status,
                ];
            })
            ->values()
            ->all();

        return view('track-results', compact(
            'shipment',
            'settings',
            'title',
            'tracking',
            'image_src',
            'shipment_history'
        ));
    }
}
