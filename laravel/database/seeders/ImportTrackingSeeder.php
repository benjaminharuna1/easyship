<?php

namespace Database\Seeders;

class ImportTrackingSeeder extends LegacySqlSeeder
{
    /**
     * Legacy package-tracking tables and their Laravel column mapping
     * (dest => source). Only the fields used by the new app are imported;
     * legacy-only columns (delivery_time, updated_time) are omitted and any
     * Laravel-specific columns are left to their defaults.
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
            'track_update' => [
                'track_num' => 'track_num',
                'status' => 'status',
                'date' => 'date',
                'time' => 'time',
                'note' => 'note',
                'current_location' => 'current_location',
                'invoice_sub_total' => 'invoice_sub_total',
                'discount' => 'discount',
                'tax' => 'tax',
                'invoice_total' => 'invoice_total',
                'created_at' => 'updated_at',
                'updated_at' => 'updated_at',
            ],
        ];
    }
}
