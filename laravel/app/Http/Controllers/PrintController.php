<?php

namespace App\Http\Controllers;

use App\Models\Addtracking;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class PrintController extends Controller
{
    public function invoice(string $trackingId)
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

        $creationDate = 'N/A';
        if ($shipment->shipmentHistory->isNotEmpty()) {
            $first = $shipment->shipmentHistory->sortBy('date')->first();
            try {
                $creationDate = Carbon::parse($first->date)->format('l, d.M.Y');
            } catch (\Throwable $e) {
                $creationDate = 'N/A';
            }
        }

        return view('print.invoice', compact('settings', 'shipment', 'creationDate'));
    }
}
