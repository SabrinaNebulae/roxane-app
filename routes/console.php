<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('members:renewal-process --phase=reminder_1')
    ->yearlyOn(12, 1, '09:00')
    ->description('1ère relance renouvellement adhésion');

Schedule::command('members:renewal-process --phase=reminder_2')
    ->yearlyOn(12, 15, '09:00')
    ->description('2ème relance renouvellement adhésion');

Schedule::command('members:renewal-process --phase=reminder_3')
    ->yearlyOn(1, 5, '09:00')
    ->description('3ème relance renouvellement adhésion');

Schedule::command('members:renewal-process --phase=deactivate')
    ->yearlyOn(1, 28, '09:00')
    ->description('Désactivation comptes non renouvelés');
