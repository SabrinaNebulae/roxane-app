<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\NextCloudMember;
use App\Services\Nextcloud\NextcloudService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SyncNextcloudMembers extends Command
{
    protected $signature = 'nextcloud:sync-members
        {--dry-run : Ne pas écrire en base}
        {--member= : Synchroniser un seul member_id}';

    protected $description = 'Synchronise les comptes Nextcloud avec les adhérents';

    public function __construct(
        protected NextcloudService $nextcloud
    ) {
        parent::__construct();
    }

    /**
     * @throws ConnectionException
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $memberFilter = $this->option('member');

        $this->info(
            $dryRun
                ? 'DRY-RUN activé'
                : 'Synchronisation Nextcloud → Members'
        );

        /** index des membres par email */
        $members = Member::query()
            ->where('email', 'like', '%@retzien.fr%')
            ->when($memberFilter, fn ($q) => $q->where('id', $memberFilter))
            ->get()
            ->filter(fn (Member $m) => !empty($m->retzien_email))
            ->keyBy(fn (Member $m) => strtolower($m->retzien_email));


        if ($members->isEmpty()) {
            $this->warn('Aucun membre à synchroniser');
            return CommandAlias::SUCCESS;
        }

        $this->info("{$members->count()} membres candidats");

        /**Récupération des users Nextcloud */
        $userIds = $this->nextcloud->listUsers();

        $this->info(count($userIds) . ' comptes Nextcloud trouvés');

        $synced = 0;

        foreach ($userIds as $userId) {
            try {
                $details = $this->nextcloud->getUserDetails($userId);

                $email = strtolower($details['email'] ?? '');

                if (!$email || !$members->has($email)) {
                    continue;
                }

                $member = $members[$email];

                $payload = [
                    'member_id' => $member->id,
                    'nextcloud_user_id' => $userId,
                    'data' => [
                        'email' => $email,
                        'quota' => $details['quota'] ?? null,
                        'groups' => $details['groups'] ?? [],
                        'enabled' => !($details['enabled'] === false),
                        'last_login' => $details['lastLogin'] ?? null,
                        'raw' => $details, // utile pour debug
                    ],
                ];

                if ($dryRun) {
                    $this->line("[DRY-RUN] {$member->id} ← {$userId}");
                } else {
                    NextCloudMember::query()->updateOrCreate(
                        [
                            'member_id' => $member->id,
                            'nextcloud_user_id' => $userId,
                        ],
                        $payload
                    );
                }

                $synced++;

            } catch (\Throwable $e) {
                Log::error('Erreur sync Nextcloud', [
                    'user_id' => $userId,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info("Synchronisation terminée ({$synced} comptes liés)");

        return CommandAlias::SUCCESS;
    }
}
