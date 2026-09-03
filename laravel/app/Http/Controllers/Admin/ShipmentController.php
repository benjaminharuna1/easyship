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
        $shipments = Addtracking::orderBy('updated_at', 'desc')->paginate(15);

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

    /**
     * Replace the shipment's whole history with the submitted rows, mirroring
     * the legacy edit page: delete the existing timeline, then re-insert the
     * rows present in the form.
     */
    protected function replaceShipmentHistory(string $trackingId, Request $request): void
    {
        ShipmentHistory::where('tracking_id', $trackingId)->delete();

        $dates = $request->input('history_date', []);
        if (empty($dates) || !is_array($dates)) {
            return;
        }

        foreach ($dates as $i => $date) {
            if ($date === null || $date === '') {
                continue;
            }
            ShipmentHistory::create([
                'tracking_id' => $trackingId,
                'date' => $date,
                'time' => $request->input("history_time.$i", ''),
                'location' => $request->input("history_location.$i", ''),
                'status' => $request->input("history_status.$i", 'Pending'),
                'updated_by' => $request->input("history_updated_by.$i", ''),
                'remarks' => $request->input("history_remarks.$i", ''),
            ]);
        }
    }

    public function edit(string $trackingId)
    {
        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])
            ->where('tracking_id', $trackingId)
            ->firstOrFail();
        $statuses = $this->statuses;
        $settings = Setting::find(1);

        $defaultNotifyBody = '<p>Dear {name},</p>'
            . '<p>We would like to let you know that there has been an update to your shipment '
            . '<strong>{tracking_id}</strong>. The current status is <strong>{status}</strong>.</p>'
            . '<p>Click the link below to view the latest tracking information:</p>'
            . '<p>{link}</p>'
            . '<p>Thank you,<br>{site_name}</p>';

        return view('admin.edit', compact('shipment', 'statuses', 'settings', 'defaultNotifyBody'));
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
                'total_freight' => $data['total_freight'] ?? $shipment->total_freight,
                'total_volumetric_weight' => $data['total_volumetric_weight'] ?? $shipment->total_volumetric_weight,
                'total_actual_weight' => $data['total_actual_weight'] ?? $shipment->total_actual_weight,
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

            // Replace shipment history exactly like the legacy edit page:
            // delete the existing timeline and re-insert the submitted rows.
            if ($request->has('history_date')) {
                $this->replaceShipmentHistory($trackingId, $request);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['db_error' => 'DATABASE ERROR: ' . $e->getMessage()])->withInput();
        }

        session()->flash('success_message', 'Shipment updated successfully.');
        return redirect()->route('admin.shipments.edit', $trackingId);
    }

    /**
     * Manually notify the user(s) of a shipment update with a custom, rich-text
     * message. The message supports dynamic tags that are replaced with the
     * shipment's details before sending.
     */
    public function notifyUpdate(Request $request, string $trackingId)
    {
        $shipment = Addtracking::where('tracking_id', $trackingId)->firstOrFail();
        $settings = Setting::find(1);

        $validated = $request->validate([
            'body' => ['required', 'string'],
            'recipient' => ['required', 'in:receiver,shipper,both'],
        ]);

        $trackingUrl = route('track.show', $shipment->tracking_id);

        $targets = [
            'receiver' => ['email' => $shipment->receiver_email, 'name' => $shipment->receiver_name],
            'shipper'  => ['email' => $shipment->sender_email,    'name' => $shipment->sender_name],
        ];

        $mailService = new MailService();
        $sentTo = [];
        $allSent = true;

        foreach ($targets as $key => $target) {
            if ($key !== $validated['recipient'] && $validated['recipient'] !== 'both') {
                continue;
            }

            $html = $this->renderNotificationBody(
                $validated['body'],
                $shipment,
                $target['name'],
                $trackingUrl,
                $settings
            );

            $ok = $mailService->send(
                $target['email'],
                'Shipment Update: ' . $shipment->tracking_id,
                'emails.custom',
                ['body' => $html]
            );

            if ($ok) {
                $sentTo[] = $target['email'];
            } else {
                $allSent = false;
            }
        }

        if (!$allSent || empty($sentTo)) {
            return response()->json(['status' => 'error', 'message' => 'Failed to send the notification. Please check your SMTP settings and logs.'], 422);
        }

        return response()->json(['status' => 'success', 'message' => 'Notification sent successfully to ' . implode(', ', $sentTo)]);
    }

    /**
     * Replace the dynamic tags in a notification body with the shipment's
     * actual values.
     */
    protected function renderNotificationBody(string $body, Addtracking $shipment, string $name, string $trackingUrl, Setting $settings): string
    {
        $linkHtml = '<a href="' . e($trackingUrl) . '" style="color:#f6a400; font-weight:bold;">' . e($trackingUrl) . '</a>';

        $replacements = [
            '{name}'         => $name,
            '{tracking_id}'  => $shipment->tracking_id,
            '{status}'       => $shipment->status,
            '{site_name}'    => $settings->sitename ?? 'EasyShip',
            '{link}'         => $linkHtml,
            '{tracking_link}' => e($trackingUrl),
        ];

        return strtr($body, $replacements);
    }

    public function destroy(string $trackingId)
    {
        DB::beginTransaction();
        try {
            PackageItem::where('tracking_id', $trackingId)->delete();
            ShipmentHistory::where('tracking_id', $trackingId)->delete();
            Addtracking::where('tracking_id', $trackingId)->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['db_error' => 'DATABASE ERROR: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function viewDetails(string $trackingId)
    {
        $shipment = Addtracking::with(['packageItems', 'shipmentHistory'])
            ->where('tracking_id', $trackingId)
            ->firstOrFail();
        $settings = Setting::find(1);
        $statuses = $this->statuses;
        return view('admin.view-details', compact('shipment', 'settings', 'statuses'));
    }
}
