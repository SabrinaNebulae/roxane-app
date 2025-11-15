<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Membership;
use App\Services\DolibarrService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use function Laravel\Prompts\progress;

class SyncDolibarrMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string */
    protected $signature = 'sync:dolibarr-members';

    /**
     * The console command description. *
     *
     * @var string */
    protected $description = 'Retrieve members data from Dolibarr';

    /**
     * Execute the console command.
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $this->info('Starting Dolibarr members import...');

        $client = new DolibarrService;

        // $doliMembers = collect($client->getAllMembers())->take(10); // For test
        $doliMembers = collect($client->getAllMembers());

        $progressBar = progress(label: 'Dolibarr Members import', steps: $doliMembers->count());
        $progressBar->start();

        // Stats trackers
        $createdMembers = 0;
        $updatedMembers = 0;
        $createdMemberships = 0;
        $updatedMemberships = 0;

        // Status mapping from Dolibarr
        $memberStatuses = [
            '-2' => 'excluded',
            '0' => 'cancelled',
            '1' => 'valid'
        ];

        foreach ($doliMembers as $member) {

            // CREATE or UPDATE MEMBER
            $newMember = Member::updateOrCreate(
                ['dolibarr_id' => $member['id']],
                [
                    'status' => $memberStatuses[$member['status']] ?? 'draft',
                    'nature' => 'physical',
                    'member_type' => $member['type'],
                    'group_id' => null,
                    'lastname' => $member['firstname'],
                    'firstname' => $member['lastname'],
                    'email' => $member['email'] ?: null,
                    'retzien_email' => '',
                    'company' => $member['societe'],
                    'website_url' => $member['url'],
                    'address' => $member['address'],
                    'zipcode' => $member['zip'],
                    'city' => $member['town'],
                    'country' => '',
                    'phone1' => $member['phone'],
                    'phone2' => $member['phone_mobile'],
                    'public_membership' => 0,
                    'created_at' => $this->toDate($member['date_creation']),
                ]
            );

            // Count member creation/update
            if ($newMember->wasRecentlyCreated) {
                $createdMembers++;
            } else {
                $updatedMembers++;
            }

            // Get subscriptions for memeber
            $memberships = collect($client->getMemberSubscriptions($member['id']));

            foreach ($memberships as $membership) {

                $membershipStatus = $membership['datef'] < now()->timestamp ? 'expired' : 'active';

                $newMembership = Membership::updateOrCreate(
                    ['dolibarr_id' => $membership['id']],
                    [
                        'member_id' => $newMember->id,
                        'admin_id' => 1,
                        'package_id' => 2, // annual subscription
                        'start_date' => $this->toDate($membership['dateh']),
                        'end_date' => $this->toDate($membership['datef']),
                        'status' => $membershipStatus,
                        'validation_date' => $this->toDate($membership['datem']),
                        'payment_method' => null,
                        'amount' => number_format($membership['amount'], 2),
                        'payment_status' => 'paid',
                        'note_public' => $membership['note_public'],
                        'note_private' => $membership['note_private'],
                        'dolibarr_user_id' => $member['id']
                    ]
                );

                // Count membership creation/update
                if ($newMembership->wasRecentlyCreated) {
                    $createdMemberships++;
                } else {
                    $updatedMemberships++;
                }
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        //  Report
        $this->info('');
        $this->info('===== IMPORT SUMMARY =====');
        $this->info("Members created : $createdMembers");
        $this->info("Members updated : $updatedMembers");
        $this->info("Memberships created : $createdMemberships");
        $this->info("Memberships updated : $updatedMemberships");
        $this->info('===========================');
        $this->info('Import completed successfully.');
    }

    /**
     * Convert timestamp to date format safely
     * @todo: export this in a service or repo
     */
    private function toDate($timestamp): ?string
    {
        return $timestamp
            ? Carbon::createFromTimestamp($timestamp)->format('Y-m-d H:i:s')
            : null;
    }
}
