<?php

use Illuminate\Support\Facades\Route;

Route::get('/call-dolibarr', function () {
    $call = new App\Services\DolibarrService;
    $members = $call->getAllMembers();
    // find specific
    $userData = collect($members)->firstWhere('id', 139);

    dd($userData);

})->name('call-dolibarr');
