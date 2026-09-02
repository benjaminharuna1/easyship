@extends('emails.layout')

@section('email_title', 'Shipment Created - ' . ($tracking_id ?? ''))

@section('content')
    <p>Dear {{ $name ?? 'Customer' }},</p>
    <p>We are pleased to inform you that your shipment has been registered with us at <strong>{{ $settings->sitename ?? 'EasyShip' }}</strong>.</p>

    <div style="background:#f4f6f9; border-left:4px solid #f6a400; padding:20px; margin:20px 0; border-radius:4px;">
        <p style="margin:0 0 12px; font-weight:bold; text-align:center; font-size:16px;">Tracking Information</p>

        <table style="width:100%; font-size:14px; border-collapse:collapse;">
            <tr>
                <td style="padding:6px 0; color:#555; width:45%;"><strong>Tracking Number</strong></td>
                <td style="padding:6px 0;"><strong style="color:#C40202;">{{ $tracking_id ?? '' }}</strong></td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Status</strong></td>
                <td style="padding:6px 0;">{{ $status ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Package</strong></td>
                <td style="padding:6px 0;">{{ $package_description ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Dispatch Location</strong></td>
                <td style="padding:6px 0;">{{ $dispatch_location ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;"><strong>Estimated Delivery Date</strong></td>
                <td style="padding:6px 0;">{{ $delivery_date ?? '' }}</td>
            </tr>
        </table>
    </div>

    <p>
        For more information visit the
        <a href="{{ rtrim($settings->site_url ?? '', '/') }}/track/{{ $tracking_id }}" style="color:#f6a400;">Tracking Page</a>.
    </p>
    <p>Thank you for choosing {{ $settings->sitename ?? 'EasyShip' }}.</p>
@endsection
