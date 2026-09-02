<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('email_title', ($settings->sitename ?? 'EasyShip') . ' Mail')</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:Arial, Helvetica, sans-serif;">
    <div style="max-width:600px; margin:0 auto; background-color:#ffffff;">
        <div style="background:#041e42; padding:24px 30px; text-align:center;">
            @if(!empty($settings->site_logo))
                <img src="{{ asset($settings->site_logo) }}" alt="{{ $settings->sitename }}" style="max-height:60px; display:inline-block;">
            @else
                <strong style="color:#ffffff; font-size:22px;">{{ $settings->sitename ?? 'EasyShip' }}</strong>
            @endif
        </div>

        <div style="padding:30px; color:#333; line-height:1.7; font-size:15px;">
            @yield('content')
        </div>

        <div style="background:#f4f6f9; padding:20px 30px; text-align:center; color:#888; font-size:13px;">
            <p style="margin:0 0 4px;"><strong>{{ $settings->sitename ?? 'EasyShip' }}</strong></p>
            @if(!empty($settings->site_address))
                <p style="margin:0 0 4px;">{!! nl2br(e($settings->site_address)) !!}</p>
            @endif
            @if(!empty($settings->email_address))
                <p style="margin:0;">{{ $settings->email_address }}</p>
            @endif
        </div>
    </div>
</body>
</html>
