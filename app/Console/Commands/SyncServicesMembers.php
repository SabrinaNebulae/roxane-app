<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Service;
use Illuminate\Console\Command;

use function Laravel\Prompts\progress;

/**
 * Synchronisation temporaire des services aux adhésions
 *
 * Attache automatiquement tous les services aux adhésions actives des membres valides.
 * Commande temporaire pour initialisation ou correction.
 *
 * Usage : php artisan memberships:sync-services
 */
class SyncServicesMembers extends Command
{
    protected $signature = 'memberships:sync-services';

    protected $description = 'Temporary command to sync services members';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Tous les membres ayant une adhésion en court ont les services activés
        $this->info('Syncing services members...');

        $members = Member::whereIn('status', ['valid', 'pending'])->get();

        $progressBar = progress(label: 'Syncing services members', steps: $members->count());

        $services = Service::all();

        foreach ($members as $member) {
            $membership = $member->memberships()->where('status', 'active')->first();
            $membership->services()->attach($services);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->info('Syncing services members done');

    }
}
