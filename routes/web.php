<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('/maintenance', function () {
    return Inertia::render('maintenance');
})->name('maintenance');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('dashboard/service-activation', [DashboardController::class, 'requestServiceActivation'])->name('dashboard.service-activation');
});

Route::get('/mentions-legales', fn () => Inertia::render('legal/mentions-legales'))->name('legal.mentions');
Route::get('/conditions-generales', fn () => Inertia::render('legal/cgu'))->name('legal.cgu');
Route::get('/confidentialite', fn () => Inertia::render('legal/confidentialite'))->name('legal.confidentialite');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/forms.php';
if (app()->environment('local')) {
    require __DIR__.'/dev-routes.php';
}
