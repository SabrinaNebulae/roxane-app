<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Services\DolibarrService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use function Deployer\timestamp;

class SyncDolibarrMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-dolibarr-members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve members data from Dolibarr';

    /**
     * Execute the console command.
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $this->info('Starting Dolibarr members import...');
        // Dolibarr API call
        $client =  new DolibarrService;
        $doliMembers = collect($client->getAllMembers());

        $progressBar = $this->output->createProgressBar(count($doliMembers));
        $progressBar->start();
        $i = 0;

        foreach ($doliMembers as $member) {
            dd($member);

            $newMember = Member::updateOrCreate([
                'dolibarr_id' => $member->id,
            ], [
                'status' => $member['status'], // @todo: faire concorder les statuts
                'nature' => 'physical',
                'member_type' => $member['type'],
                'group_id' => null,
                'lastname' => $member['firstname'],
                'firstname' => $member['lastname'],
                'email' => $member['email'],
                'personal_email' => '',
                'company' => '',
                'website_url' => $member['url'],
                'date_of_birth' => '',
                'address' => '',
                'zipcode' => '',
                'city' => '',
                'country' => '',
                'phone1' => '',
                'phone2' => '',
                'public_membership' => '',
                'created_at' => Carbon::create($member['date_creation'])->format(timestamp()),
                'updated_at' => '',
            ]);

            // On crée l'adhérent en remplissant les données en bdd avec ses coordonnées, son statut etc ...

            // On récupère toutes les adhésions/cotisations pour chaque adhérent
            $memberships = $client->getMemberSubscriptions($member->id);

            // on traite les notes (privée, publique, lien ect) contenues dans dolibarr

            $i++;
        }

        $progressBar->finish();
        // Logs

        $this->info('Import finished. ' .$i.' members have been imported.');
    }
}
