<?php

namespace App\Console\Commands;

use App\Models\ListmonkMember;
use App\Models\Member;
use App\Services\ListMonk\ListMonkService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

use function Laravel\Prompts\progress;

class SyncListmonkMembers extends Command
{
    protected $signature = 'listmonk:sync-members
        {--dry-run : Run without writing to the database}
        {--member= : Sync a single member by member_id}';

    protected $description = 'Sync Listmonk user accounts with members';

    public function __construct(
        protected ListMonkService $listmonk
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
                ? 'DRY-RUN enabled'
                : 'Syncing Listmonk → Members'
        );

        $members = Member::query()
            ->when($memberFilter, fn ($q) => $q->where('id', $memberFilter))
            ->get()
            ->filter(fn (Member $m) => ! empty($m->retzien_email))
            ->keyBy(fn (Member $m) => strtolower($m->retzien_email));

        if ($members->isEmpty()) {
            $this->warn('No members to sync');

            return CommandAlias::SUCCESS;
        }

        $this->info("{$members->count()} members to sync");

        $listmonkUsers = $this->listmonk->getUsers();

        dd($listmonkUsers);

        $this->info(count($listmonkUsers).' Listmonk users found');

        $progress = null;

        if (! $dryRun) {
            $progress = progress(
                label: 'Syncing members',
                steps: $members->count()
            );
            $progress->start();
        }

        $synced = 0;

        foreach ($listmonkUsers as $user) {
            try {
                $email = strtolower($user['email'] ?? '');

                if (! $email || ! $members->has($email)) {
                    continue;
                }

                $member = $members[$email];

                if ($dryRun) {
                    $this->line("[DRY-RUN] {$member->id} ({$email}) ← Listmonk user #{$user['id']}");
                } else {
                    ListmonkMember::query()->updateOrCreate(
                        ['member_id' => $member->id],
                        [
                            'listmonk_user_id' => $user['id'],
                            'data' => $user,
                        ]
                    );

                    $progress?->advance();
                }

                $synced++;
            } catch (\Throwable $e) {
                Log::error('Listmonk sync error', [
                    'user' => $user['id'] ?? null,
                    'error' => $e->getMessage(),
                ]);

                $progress?->advance();
            }
        }

        if ($progress) {
            $progress->finish();
            $this->newLine();
        }

        $this->info("Sync complete — {$synced} accounts linked");

        return CommandAlias::SUCCESS;
    }
}
