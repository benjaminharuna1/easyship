@extends('emails.layout')

@section('email_title', 'Test Email')

@section('content')
    <h2 style="margin:0 0 15px; color:#041e42;">Test Email</h2>
    <p>Hello!</p>
    <p>This is a test email to confirm that your email configuration is working correctly.</p>
    <p>If you are reading this, it means your SMTP settings are configured properly and emails are being sent successfully from <strong>{{ $settings->sitename ?? 'EasyShip' }}</strong>.</p>
    <p>No action is required. You can safely ignore this message.</p>
@endsection
