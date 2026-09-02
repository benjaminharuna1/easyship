@extends('emails.layout')

@section('email_title', 'New Contact Form Message')

@section('content')
    <h2 style="margin:0 0 15px; color:#041e42;">New Contact Form Message</h2>
    <p>A new message has been submitted through the contact form on the website.</p>

    <table style="width:100%; font-size:14px; border-collapse:collapse;">
        <tr>
            <td style="padding:6px 0; color:#555; width:30%;"><strong>Name</strong></td>
            <td style="padding:6px 0;">{{ $name ?? '' }}</td>
        </tr>
        <tr>
            <td style="padding:6px 0; color:#555;"><strong>Email</strong></td>
            <td style="padding:6px 0;">{{ $email ?? '' }}</td>
        </tr>
        @if(!empty($mobile))
        <tr>
            <td style="padding:6px 0; color:#555;"><strong>Mobile</strong></td>
            <td style="padding:6px 0;">{{ $mobile }}</td>
        </tr>
        @endif
        @if(!empty($company))
        <tr>
            <td style="padding:6px 0; color:#555;"><strong>Company</strong></td>
            <td style="padding:6px 0;">{{ $company }}</td>
        </tr>
        @endif
    </table>

    <div style="background:#f4f6f9; padding:15px; margin:15px 0; border-radius:4px; border-left:4px solid #f6a400;">
        <strong>Message:</strong>
        <p style="margin:8px 0 0;">{{ $message ?? '' }}</p>
    </div>
@endsection
