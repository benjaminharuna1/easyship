<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addtracking;
use App\Models\PackageItem;
use App\Models\Setting;
use App\Models\ShipmentHistory;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    protected array $statuses = [
        'Pending', 'In Process', 'In Transit', 'On Hold',
        'Delivered', 'Completed', 'Cancelled', 'Returned',
    ];

    public function generateTrackingNumber(): string
    {
        $trackPrefix = 'CL';
        $random = str_shuffle('12345678900987654321');
        $random = substr($random, 0, 7);
        return $trackPrefix . date('m') . $random;
    }

    public function create()
    {
        $settings = Setting::find(1);
        $trackingNumber = $this->generateTrackingNumber();
        return view('admin.add-tracking', compact('settings', 'trackingNumber'))->with('statuses', $this->statuses);
    }

    public function list()
    {
        $shipments = Addtracking::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.shipments-list', compact('shipments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tracking_id' => ['nullable', 'string'],
            'sendername' => ['required', 'string'],
            'sendercontact' => ['required', 'string'],
            'senderemail' => ['required', 'email'],
            'senderaddress' => ['required', 'string'],
            'dispatchlocation' => ['required', 'string'],
            'destination' => ['required', 'string'],
            'carrier' => ['required', 'string'],
            'courier' => ['nullable', 'string'],
            'carrierreferencenumber' => ['required', 'string'],
            'weight' => ['required', 'string'],
            'total_cost' => ['required', 'numeric'],
            'total_freight' => ['nullable', 'numeric'],
            'total_volumetric_weight' => ['nullable', 'numeric'],
            'total_actual_weight' => ['nullable', 'numeric'],
            'paymentmode' => ['required', 'string'],
            'receivername' => ['required', 'string'],
            'receiver_email' => ['required', 'email'],
            'receivercontact' => ['required', 'string'],
            'receiveraddress' => ['required', 'string'],
            'packagedescription' => ['required', 'string'],
            'dispatch_date' => ['required', 'date'],
            'estimateddeliverydate' => ['required', 'date'],
            'shipmentmethod' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'type_of_shipment' => ['nullable', 'string'],
            'comments' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif'],
            'package_quantity' => ['nullable', 'array'],
            'package_quantity.*' => ['nullable', 'integer'],
            'package_piece_type.*' => ['nullable', 'string'],
            'package_description.*' => ['nullable', 'string'],
            'package_length.*' => ['nullable', 'numeric'],
            'package_width.*' => ['nullable', 'numeric'],
            'package_height.*' => ['nullable', 'numeric'],
            'package_weight.*' => ['nullable', 'numeric'],
            'history_date.*' => ['nullable', 'date'],
            'history_time.*' => ['nullable', 'string'],
            'history_location.*' => ['nullable', 'string'],
            'history_status.*' => ['nullable', 'string'],
            'history_updated_by.*' => ['nullable', 'string'],
            'history_remarks.*' => ['nullable', 'string'],
        ]);

        $published = $request->has('publish') ? 1 : 0;
        $sendEmail = $request->boolean('send_email_notification');

        try {
            DB::beginTransaction();

            $trackingId = !empty($data['tracking_id'])
                ? $data['tracking_id']
                : ($request->input('auto_tracking_id', $this->generateTrackingNumber()));

            $image = '';
            if ($request->hasFile('image')) {
                $image = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads'), $image);
            }

            $addtracking = Addtracking::create([
                'tracking_id' => $trackingId,
                'sender_name' => $data['sendername'],
                'sender_contact' => $data['sendercontact'],
                'sender_email' => $data['senderemail'],
                'sender_address' => $data['senderaddress'],
                'dispatch_location' => $data['dispatchlocation'],
                'destination' => $data['destination'],
                'carrier' => $data['carrier'],
                'courier' => $data['courier'] ?? null,
                'carrier_refrence_number' => $data['carrierreferencenumber'],
                'weight' => $data['weight'],
                'total_cost' => $data['total_cost'],
                'total_freight' => $data['total_freight'] ?? null,
                'total_volumetric_weight' => $data['total_volumetric_weight'] ?? null,
                'total_actual_weight' => $data['total_actual_weight'] ?? null,
                'payment_mode' => $data['paymentmode'],
                'receiver_name' => $data['receivername'],
                'receiver_email' => $data['receiver_email'],
                'receiver_contact' => $data['receivercontact'],
                'receiver_address' => $data['receiveraddress'],
                'package_discription' => $data['packagedescription'],
                'dispatch_date' => $data['dispatch_date'],
                'estimated_delivery_date' => $data['estimateddeliverydate'],
                'shipment_mode' => $data['shipmentmethod'],
                'quantity' => $data['quantity'],
                'type_of_shipment' => $data['type_of_shipment'] ?? null,
                'comments' => $data['comments'] ?? null,
                'image' => $image,
                'published' => $published,
                'status' => 'Pending',
                'date_added' => now()->format('Y-m-d H:i:s'),
            ]);

            // Package items
            $this->insertPackageItems($trackingId, $request);
            // Shipment history
            $status = $this->insertShipmentHistory($trackingId, $request, $data['dispatchlocation']);

            $addtracking->update(['status' => $status]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['db_error' => 'DATABASE ERROR: ' . $e->getMessage()])->withInput();
        }

        if ($sendEmail) {
            $settings = Setting::find(1);
            $mailService = new MailService();
            $baseData = [
                'tracking_id' => $trackingId,
                'status' => $status,
                'package_description' => $data['packagedescription'],
                'dispatch_location' => $data['dispatchlocation'],
                'delivery_date' => $data['estimateddeliverydate'],
            ];
            $mailService->send($data['receiver_email'], "Shipment Created: " . $trackingId, 'emails.shipment_creation', array_merge($baseData, ['name' => $data['receivername']]));
            $mailService->send($data['senderemail'], "Shipment Created: " . $trackingId, 'emails.shipment_creation', array_merge($baseData, ['name' => $data['sendername']]));
        }

        session()->flash('success_message', "Shipment created successfully with Tracking ID: " . $trackingId);
        return redirect()->route('admin.shipments.edit', $trackingId);
    }

    protected function insertPackageItems(string $trackingId, Request $request): void
    {
        $quantities = $request->input('package_quantity', []);
        if (empty($quantities) || !is_array($quantities)) {
            return;
        }
        foreach ($quantities as $i => $qty) {
            if ($qty === null || $qty === '') {
                continue;
            }
            PackageItem::create([
                'tracking_id' => $trackingId,
                'quantity' => $qty,
                'piece_type' => $request->input("package_piece_type.$i", ''),
                'description' => $request->input("package_description.$i", ''),
                'length' => $request->input("package_length.$i", 0),
                'width' => $request->input("package_width.$i", 0),
                'height' => $request->input("package_height.$i", 0),
                'weight' => $request->input("package_weight.$i", 0),
            ]);
        }
    }

    protected function insertShipmentHistory(string $trackingId, Request $request, string $defaultLocation): string
    {
        $dates = $request->input('history_date', []);
        $status = 'Pending';

        if (!empty($dates) && is_array($dates)) {
            foreach ($dates as $i => $date) {
                if ($date === null || $date === '') {
                    continue;
                }
                $currentStatus = $request->input("history_status.$i", 'Pending');
                ShipmentHistory::create([
                    'tracking_id' => $trackingId,
                    'date' => $date,
                    'time' => $request->input("history_time.$i", ''),
                    'location' => $request->input("history_location.$i", ''),
                    'status' => $currentStatus,
                    'updated_by' => $request->input("history_updated_by.$i", ''),
                    'remarks' => $request->input("history_remarks.$i", ''),
                ]);
                $status = $currentStatus;
            }
        }

        // Auto-log creation event
        ShipmentHistory::create([
            'tracking_id' => $trackingId,
            'date' => now()->toDateString(),
            'time' => now()->format('H:i:s'),
            'location' => $defaultLocation,
            'status' => $status,
            'updated_by' => 'System',
            'remarks' => 'Shipment Created',
        ]);

        return $status;
    }

    public function edit(string $trackingId)
    {
        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])
            ->where('tracking_id', $trackingId)
            ->firstOrFail();
        $statuses = $this->statuses;
        $settings = Setting::find(1);
        return view('admin.edit', compact('shipment', 'statuses', 'settings'));
    }

    public function update(Request $request, string $trackingId)
    {
        $shipment = Addtracking::where('tracking_id', $trackingId)->firstOrFail();

        $data = $request->validate([
            'sendername' => ['required', 'string'],
            'sendercontact' => ['required', 'string'],
            'senderemail' => ['required', 'email'],
            'senderaddress' => ['required', 'string'],
            'dispatchlocation' => ['required', 'string'],
            'destination' => ['required', 'string'],
            'carrier' => ['required', 'string'],
            'carrierreferencenumber' => ['required', 'string'],
            'weight' => ['required', 'string'],
            'total_cost' => ['required', 'numeric'],
            'paymentmode' => ['required', 'string'],
            'receivername' => ['required', 'string'],
            'receiver_email' => ['required', 'email'],
            'receivercontact' => ['required', 'string'],
            'receiveraddress' => ['required', 'string'],
            'packagedescription' => ['required', 'string'],
            'dispatch_date' => ['required', 'date'],
            'estimateddeliverydate' => ['required', 'date'],
            'shipmentmethod' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'status' => ['nullable', 'string'],
            'courier' => ['nullable', 'string'],
            'type_of_shipment' => ['nullable', 'string'],
            'comments' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif'],
            'package_quantity' => ['nullable', 'array'],
            'history_date' => ['nullable', 'array'],
        ]);

        try {
            DB::beginTransaction();

            $shipment->fill([
                'sender_name' => $data['sendername'],
                'sender_contact' => $data['sendercontact'],
                'sender_email' => $data['senderemail'],
                'sender_address' => $data['senderaddress'],
                'dispatch_location' => $data['dispatchlocation'],
                'destination' => $data['destination'],
                'carrier' => $data['carrier'],
                'courier' => $data['courier'] ?? $shipment->courier,
                'carrier_refrence_number' => $data['carrierreferencenumber'],
                'weight' => $data['weight'],
                'total_cost' => $data['total_cost'],
                'payment_mode' => $data['paymentmode'],
                'receiver_name' => $data['receivername'],
                'receiver_email' => $data['receiver_email'],
                'receiver_contact' => $data['receivercontact'],
                'receiver_address' => $data['receiveraddress'],
                'package_discription' => $data['packagedescription'],
                'dispatch_date' => $data['dispatch_date'],
                'estimated_delivery_date' => $data['estimateddeliverydate'],
                'shipment_mode' => $data['shipmentmethod'],
                'quantity' => $data['quantity'],
                'type_of_shipment' => $data['type_of_shipment'] ?? $shipment->type_of_shipment,
                'comments' => $data['comments'] ?? $shipment->comments,
                'status' => $data['status'] ?? $shipment->status,
            ]);

            if ($request->hasFile('image')) {
                $image = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('uploads'), $image);
                $shipment->image = $image;
            }

            $shipment->save();

            if ($request->boolean('clear_package_items')) {
                PackageItem::where('tracking_id', $trackingId)->delete();
                $this->insertPackageItems($trackingId, $request);
            }

            if ($request->input('history_date')) {
                $this->insertShipmentHistory($trackingId, $request, $data['dispatchlocation']);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['db_error' => 'DATABASE ERROR: ' . $e->getMessage()])->withInput();
        }

        session()->flash('success_message', 'Shipment updated successfully.');
        return redirect()->route('admin.shipments.edit', $trackingId);
    }

    public function destroy(string $trackingId)
    {
        Addtracking::where('tracking_id', $trackingId)->delete();
        return redirect()->route('admin.dashboard');
    }

    public function viewDetails(string $trackingId)
    {
        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])
            ->where('tracking_id', $trackingId)
            ->firstOrFail();
        return view('admin.view-details', compact('shipment'));
    }
}
