<?php

use Illuminate\Support\Facades\Route;

// Test Dolibarr API
/*Route::get('/call-dolibarr', function () {
    $call = new \App\Services\Dolibarr\DolibarrService;
    $members = $call->getAllMembers();
    // find specific
    $userData = collect($members)->firstWhere('id', 124); // Isabelle AK

    //dd($userData);
    $subscriptions = collect($call->getMemberSubscriptions(124))->firstWhere('id', 324);
    dd($subscriptions);
    $date1 = \Carbon\Carbon::createFromTimestamp($subscriptions['datec'])->format('d/m/Y');
    $date2 = \Carbon\Carbon::createFromTimestamp($subscriptions['datem'])->format('d/m/Y');
    $date3 = \Carbon\Carbon::createFromTimestamp($subscriptions['dateh'])->format('d/m/Y');
    $date4 = \Carbon\Carbon::createFromTimestamp($subscriptions['datef'])->format('d/m/Y');

    dd($date1, $date2, $date3, $date4);

})->name('call-dolibarr');

Route::get('/test-dolibarr', function () {
    $dolibarrService = new \App\Services\Dolibarr\DolibarrService();

    $members = $dolibarrService->getAllMembers();

    dd($members);
});
*/

// Test ISPConfig
/*Route::get('/test/sync-ispconfig', function () {

    if (!app()->isLocal()) {
        abort(403);
    }

    Artisan::call('sync:ispconfig-web-members');

    return response()->json([
        'status' => 'ok',
        'output' => Artisan::output(),
    ]);
});

// Test ISPConfig Mail
Route::get('/test/isp-mails', function() {
    $ispService = new \App\Services\ISPConfig\ISPConfigMailService;

    return $ispService->getAllMailDomains();
});*/

// Test info user on Front

// Temporary mail test route — remove after debugging
Route::get('/test/mail', function (\Illuminate\Http\Request $request) {
    $token = config('app.debug_mail_token');

    if (! $token || $request->query('token') !== $token) {
        abort(403);
    }

    $to = $request->query('to');

    if (! $to || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return response()->json(['error' => 'Provide a valid ?to=email@example.com'], 422);
    }

    \Illuminate\Support\Facades\Mail::raw('Test mail from Roxane — SMTP is working.', function ($message) use ($to) {
        $message->to($to)->subject('Roxane — SMTP test');
    });

    return response()->json(['status' => 'sent', 'to' => $to]);
});
