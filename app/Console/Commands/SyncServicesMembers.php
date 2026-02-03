<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Service;
use Illuminate\Console\Command;
use function Laravel\Prompts\progress;

class SyncServicesMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'memberships:sync-services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Temporary command to sync services members';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Tous les membres ayant une adhésion en court ont les services activés
        $this->info('Syncing services members...');

        $members = Member::whereIn('status', ['valid', 'pending'] )->get();

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
