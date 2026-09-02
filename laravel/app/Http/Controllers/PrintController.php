<?php

namespace App\Http\Controllers;

use App\Models\Addtracking;
use App\Models\Setting;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function invoice(Request $request)
    {
        $trackingId = trim($request->query('num', ''));

        $settings = Setting::find(1);
        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])
            ->where('tracking_id', $trackingId)
            ->first();

        $creationDate = 'N/A';
        if ($shipment && $shipment->shipmentHistory->isNotEmpty()) {
            $first = $shipment->shipmentHistory->sortBy('date')->first();
            try {
                $creationDate = \Illuminate\Support\Carbon::parse($first->date)->format('l, d.M.Y');
            } catch (\Throwable $e) {
                $creationDate = 'N/A';
            }
        }

        return view('print.invoice', compact('settings', 'shipment', 'creationDate'));
    }
}
