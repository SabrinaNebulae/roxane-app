<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/welcome', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('/', function () {
    return Inertia::render('maintenance');
})->name('maintenance');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// TEST

Route::get('/test/sync-ispconfig', function () {

    if (!app()->isLocal()) {
        abort(403);
    }

    Artisan::call('sync:ispconfig-web-members');

    return response()->json([
        'status' => 'ok',
        'output' => Artisan::output(),
    ]);
});

Route::get('/test/isp-mails', function() {
    $ispService = new \App\Services\ISPConfig\ISPConfigMailService;

    return $ispService->getAllMailDomains();
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/forms.php';
require __DIR__.'/dev-routes.php';
