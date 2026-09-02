<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ImportTrackingSeeder extends LegacySqlSeeder
{
    /**
     * Legacy package-tracking tables and their Laravel column mapping
     * (dest => source). Only the fields used by the new app are imported;
     * legacy-only columns (delivery_time, updated_time) are omitted and any
     * Laravel-specific columns are left to their defaults.
     *
     * NOTE: track_update is intentionally NOT listed here. Its legacy rows are
     * folded into shipment_history by run() so every shipment's tracking
     * timeline lives in a single table (shipment_history) in the new app.
     */
    protected function tables(): array
    {
        return [
            'addtracking' => [
                'tracking_id' => 'tracking_id',
                'sender_name' => 'sender_name',
                'sender_contact' => 'sender_contact',
                'sender_email' => 'sender_email',
                'sender_address' => 'sender_address',
                'status' => 'status',
                'dispatch_location' => 'dispatch_location',
                'carrier' => 'carrier',
                'carrier_refrence_number' => 'carrier_refrence_number',
                'weight' => 'weight',
                'payment_mode' => 'payment_mode',
                'total_cost' => 'total_cost',
                'image' => 'image',
                'receiver_name' => 'receiver_name',
                'receiver_contact' => 'receiver_contact',
                'receiver_email' => 'receiver_email',
                'receiver_address' => 'receiver_address',
                'destination' => 'destination',
                'package_discription' => 'package_discription',
                'dispatch_date' => 'dispatch_date',
                'estimated_delivery_date' => 'estimated_delivery_date',
                'shipment_mode' => 'shipment_mode',
                'quantity' => 'quantity',
                'message' => 'message',
                'current_location' => 'current_location',
                'delivery_message' => 'delivery_message',
                'date_added' => 'date_added',
                'remarks' => 'remarks',
                'total_freight' => 'total_freight',
                'courier' => 'courier',
                'origin' => 'origin',
                'comments' => 'comments',
                'datetimepicker' => 'datetimepicker',
                'type_of_shipment' => 'type_of_shipment',
                'total_volumetric_weight' => 'total_volumetric_weight',
                'total_actual_weight' => 'total_actual_weight',
                'published' => 'published',
                'coordinates' => 'coordinates',
                'created_at' => '__NOW__',
                'updated_at' => '__NOW__',
            ],
            'package_items' => [
                'tracking_id' => 'tracking_id',
                'quantity' => 'quantity',
                'piece_type' => 'piece_type',
                'description' => 'description',
                'length' => 'length',
                'width' => 'width',
                'height' => 'height',
                'weight' => 'weight',
                'created_at' => '__NOW__',
                'updated_at' => '__NOW__',
            ],
            'shipment_history' => [
                'tracking_id' => 'tracking_id',
                'date' => 'date',
                'time' => 'time',
                'location' => 'location',
                'status' => 'status',
                'updated_by' => 'updated_by',
                'remarks' => 'remarks',
                'created_at' => '__NOW__',
                'updated_at' => '__NOW__',
            ],
        ];
    }

    /**
     * Import the standard tracking tables, then fold any legacy track_update
     * rows into shipment_history so the timeline is not "missing" for
     * shipments whose history lived only in the old track_update table.
     */
    public function run(): void
    {
        $path = database_path('legacy/exprkfmf_easyship.sql');
        if (!is_file($path) && is_file(base_path('exprkfmf_easyship.sql'))) {
            $path = base_path('exprkfmf_easyship.sql');
        }

        parent::run();

        if (!is_file($path)) {
            return;
        }

        $content = file_get_contents($path);
        $parsed = $this->extractInsert($content, 'track_update');

        if ($parsed === null) {
            return;
        }

        [$columns, $rows] = $parsed;

        $shipmentIds = DB::table('addtracking')
            ->pluck('tracking_id')
            ->map(fn ($v) => (string) $v)
            ->all();

        // Only fold in a track_update timeline for shipments that have no
        // shipment_history rows yet, to avoid duplicating an existing timeline.
        $histIds = DB::table('shipment_history')
            ->pluck('tracking_id')
            ->map(fn ($v) => (string) $v)
            ->unique()
            ->flip()
            ->all();

        $inserts = [];
        foreach ($rows as $row) {
            $src = array_combine($columns, $row);
            $trackNum = trim((string) ($src['track_num'] ?? ''));

            if ($trackNum === '' || !in_array($trackNum, $shipmentIds, true)) {
                continue;
            }
            if (isset($histIds[$trackNum])) {
                continue;
            }

            $inserts[] = [
                'tracking_id' => $trackNum,
                'date' => $src['date'] ?? null,
                'time' => $src['time'] ?? null,
                'location' => $src['current_location'] ?? '',
                'status' => $src['status'] ?? '',
                'updated_by' => 'Admin',
                'remarks' => $src['note'] ?? '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        if (!empty($inserts)) {
            DB::table('shipment_history')->insert($inserts);
            $this->command?->info("Folded track_update into shipment_history (" . count($inserts) . " rows)");
        }
    }
}
