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

        if ($settings && $settings->maintenance_mode) {
            // Allow logged-in admins, the login page, and all admin routes
            // (including the exact /admin dashboard path) through.
            $isAdminRoute = $request->is('admin/*') || $request->path() === 'admin';
            $isLoginRoute = $request->is('login');

            if (!$isAdminRoute && !$isLoginRoute && !auth('admin')->check()) {
                return response()->view('maintenance', ['settings' => $settings], 503);
            }
        }

        return $next($request);
    }
}
