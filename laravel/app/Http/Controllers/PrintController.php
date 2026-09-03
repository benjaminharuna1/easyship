<?php

namespace App\Http\Controllers;

use App\Models\Addtracking;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $trackingUrl = route('track.show', $trackingId);
        $qrSvg = QrCode::format('svg')
            ->size(210)
            ->margin(1)
            ->color(4, 30, 66)
            ->generate($trackingUrl);
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        return view('print.invoice', compact('settings', 'shipment', 'creationDate', 'qrCode', 'trackingUrl'));
    }
}
