<?php

namespace App\Http\Controllers;

use App\Models\Addtracking;
use App\Models\Setting;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::find(1);
        $title = 'Track Shipment';

        // A submitted search number (GET) is redirected to the canonical
        // /track/{trackingId} URL so results stay shareable/bookmarkable.
        $tracking = trim((string) $request->query('search_P', ''));

        if ($tracking !== '') {
            $exists = Addtracking::where('tracking_id', $tracking)->exists();

            if (!$exists) {
                return redirect()->route('track')->with('error', 'Tracking id Not Found');
            }

            return redirect()->route('track.show', $tracking);
        }

        return view('track', compact('settings', 'title'));
    }

    public function show(string $trackingId)
    {
        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])
            ->where('tracking_id', $trackingId)
            ->first();

        if (!$shipment) {
            return redirect()
                ->route('track')
                ->with('error', 'Tracking id Not Found');
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

        $geocodeApiKey = $settings->geocode_api_key ?? '';

        return view('track-results', compact(
            'shipment',
            'settings',
            'title',
            'trackingId',
            'image_src',
            'shipment_history',
            'geocodeApiKey'
        ));
    }
}
