<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->sitename ?? 'EasyShip' }} | Maintenance</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($settings->site_favicon ?? '') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/01-bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { height: 100vh; display: flex; align-items: center; justify-content: center; background: #f6f7fb; font-family: Arial, Helvetica, sans-serif; color: #041e42; text-align: center; }
        .maint-box { max-width: 480px; padding: 40px; }
        .maint-box .icon { font-size: 80px; color: #f6a400; margin-bottom: 20px; }
        .maint-box h1 { font-size: 32px; margin-bottom: 15px; }
        .maint-box p { color: #777; font-size: 16px; line-height: 1.7; }
        .maint-box .logo { margin-bottom: 25px; }
        .maint-box .logo img { max-height: 60px; }
    </style>
</head>
<body>
    <div class="maint-box">
        <div class="logo">
            <img src="{{ asset($settings->site_logo ?? '') }}" alt="Logo">
        </div>
        <div class="icon"><i class="fas fa-tools"></i></div>
        <h1>We'll Be Back Soon!</h1>
        <p>Our website is currently undergoing scheduled maintenance to improve your experience. We appreciate your patience and will be back online shortly.</p>
    </div>
</body>
</html>
