<?php

namespace App\Console\Commands;

use App\Services\Dolibarr\DolibarrService;
use App\Services\ISPConfig\ISPConfigMailService;
use App\Services\Nextcloud\NextcloudService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class HandleExpiredMembersDolibarr extends Command
{
    protected $signature = 'members:cleanup-expired';
    protected $description = 'Résilie les adhérents expirés et désactive leurs services';

    public function __construct(
        protected DolibarrService $dolibarr,
        protected ISPConfigMailService $mailService,
        protected NextcloudService $nextcloud
    ) {
        parent::__construct();
    }

    /**
     * @throws ConnectionException
     */
    public function handle(): int
    {
        $this->info('Récupération des adhérents Dolibarr');

        $members = collect($this->dolibarr->getAllMembers());

        $expiredMembers = $members->filter(fn ($m) => $m['status'] === 'expired');

        $this->info("{$expiredMembers->count()} adhérent(s) expiré(s)");

        foreach ($expiredMembers as $member) {
            try {
                $this->processMember($member);
            } catch (\Throwable $e) {
                Log::error('Erreur traitement adhérent', [
                    'member_id' => $member['id'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info('Traitement terminé');
        return Command::SUCCESS;
    }

    protected function processMember(array $member): void
    {
        $email = $member['email'] ?? null;

        $this->info("👤 {$member['id']} - {$email}");

        // 1. Résiliation Dolibarr
        $this->dolibarr->setMemberStatus($member['id'], 'resilie');

        // 2. Désactivation mail ISPConfig
        if ($email) {
            $this->disableMailAccount($email);
        }

        // 3. Désactivation Nextcloud
        if ($email) {
            $this->nextcloud->disableUserByEmail($email);
        }
    }

    protected function disableMailAccount(string $email): void
    {
        $details = $this->mailService->getMailUserDetails($email);

        if (!$details) {
            $this->warn("Boîte mail inexistante : {$email}");
            return;
        }

        $this->mailService->updateMailUser($email, [
            'postfix' => 'n',
            'disablesmtp' => 'y',
            'disableimap' => 'y',
            'disablepop3' => 'y',
        ]);

        $this->info("📧 Mail désactivé");
    }
}
