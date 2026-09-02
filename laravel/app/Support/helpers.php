<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Route;

if (!function_exists('process_shortcodes')) {
    function process_shortcodes(string $content): string
    {
        $settings = Setting::find(1);

        $map = [
            '[site-name]' => $settings->sitename ?? '',
            '[site-url]' => $settings->site_url ?? '',
            '[email-name]' => $settings->email_name ?? '',
            '[email-address]' => $settings->email_address ?? '',
            '[phone-number]' => $settings->phone_number ?? '',
            '[fax-number]' => $settings->fax_number ?? '',
            '[site-address]' => $settings->site_address ?? '',
        ];

        foreach ($map as $shortcode => $value) {
            $content = str_replace($shortcode, e($value), $content);
        }

        return $content;
    }
}

if (!function_exists('is_admin_route')) {
    function is_admin_route(): bool
    {
        return Route::is('admin.*');
    }
}
