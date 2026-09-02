<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $settings = Setting::find(1);

        if ($settings && $settings->maintenance_mode && !$request->is('admin/*') && !$request->is('login')) {
            return response()->view('maintenance', ['settings' => $settings], 503);
        }

        return $next($request);
    }
}
