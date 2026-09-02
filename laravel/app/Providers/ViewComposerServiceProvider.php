<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if ($view->getName() === 'welcome' || str_starts_with($view->getName(), 'errors')) {
                return;
            }

            if (!isset($view->getData()['settings'])) {
                try {
                    $settings = Setting::find(1) ?? new Setting();
                } catch (\Throwable $e) {
                    $settings = new Setting();
                }
                $view->with('settings', $settings);
            }

            if (!isset($view->getData()['sitename'])) {
                $view->with('sitename', $view->getData()['settings']->sitename ?? 'EasyShip');
            }
        });
    }
}
