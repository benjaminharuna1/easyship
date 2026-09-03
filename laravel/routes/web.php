<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/services', ServicesController::class)->name('services');
Route::get('/contact', ContactController::class)->name('contact');
Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');

Route::get('/track', [TrackController::class, 'index'])->name('track');

// Legacy: /track/print?num=CL... redirects to the new pretty print URL.
Route::get('/track/print', function (\Illuminate\Http\Request $request) {
    $num = trim((string) $request->query('num', ''));

    if ($num !== '') {
        return redirect()->route('track.print', $num);
    }

    return redirect()->route('track');
})->name('track.print.legacy');

// Legacy POST: /track/results (the old search form) now lands on /track which
// performs the same lookup and redirects to the canonical /track/{id}.
Route::post('/track/results', function (\Illuminate\Http\Request $request) {
    $tracking = trim((string) $request->input('search_P', ''));
    return redirect()->route('track', $tracking === '' ? [] : ['search_P' => $tracking]);
})->name('track.results.legacy');

Route::get('/track/{trackingId}', [TrackController::class, 'show'])->name('track.show');
Route::get('/track/{trackingId}/print', [PrintController::class, 'invoice'])->name('track.print');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

        // Shipments
        Route::get('/shipments', [App\Http\Controllers\Admin\ShipmentController::class, 'list'])->name('shipments.list');
        Route::get('/shipments/create', [App\Http\Controllers\Admin\ShipmentController::class, 'create'])->name('shipments.create');
        Route::post('/shipments', [App\Http\Controllers\Admin\ShipmentController::class, 'store'])->name('shipments.store');
        Route::get('/shipments/{trackingId}/edit', [App\Http\Controllers\Admin\ShipmentController::class, 'edit'])->name('shipments.edit');
        Route::put('/shipments/{trackingId}', [App\Http\Controllers\Admin\ShipmentController::class, 'update'])->name('shipments.update');
        Route::delete('/shipments/{trackingId}', [App\Http\Controllers\Admin\ShipmentController::class, 'destroy'])->name('shipments.destroy');
        Route::get('/shipments/{trackingId}', [App\Http\Controllers\Admin\ShipmentController::class, 'viewDetails'])->name('shipments.show');

        // Settings
        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/site', [App\Http\Controllers\Admin\SettingsController::class, 'updateSiteSettings'])->name('settings.site');
        Route::post('/settings/homepage', [App\Http\Controllers\Admin\SettingsController::class, 'updateHomepageContent'])->name('settings.homepage');
        Route::post('/settings/email', [App\Http\Controllers\Admin\SettingsController::class, 'updateEmailSettings'])->name('settings.email');
        Route::post('/settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneralSettings'])->name('settings.general');

        // Services
        Route::resource('services', App\Http\Controllers\Admin\ServiceController::class, ['except' => ['show'], 'names' => 'services']);

        // Team
        Route::resource('team', App\Http\Controllers\Admin\TeamController::class, ['except' => ['show'], 'names' => 'team']);

        // Testimonials
        Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class, ['except' => ['show'], 'names' => 'testimonials']);

        // Legal
        Route::get('/legal', [App\Http\Controllers\Admin\LegalController::class, 'index'])->name('legal');
        Route::post('/legal', [App\Http\Controllers\Admin\LegalController::class, 'update'])->name('legal.update');

        // Support messages
        Route::get('/support-messages', [App\Http\Controllers\Admin\SupportController::class, 'index'])->name('support');

        // Email
        Route::get('/send-email', [App\Http\Controllers\Admin\EmailController::class, 'sendForm'])->name('email.send-form');
        Route::post('/send-email', [App\Http\Controllers\Admin\EmailController::class, 'send'])->name('email.send');
        Route::post('/test-email', [App\Http\Controllers\Admin\EmailController::class, 'testSend'])->name('email.test-send');

        // Profile
        Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'editForm'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    });
});
