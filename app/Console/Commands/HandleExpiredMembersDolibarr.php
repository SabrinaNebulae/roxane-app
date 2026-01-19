<?php

namespace App\Console\Commands;

use App\Services\Dolibarr\DolibarrService;
use App\Services\ISPConfig\ISPConfigMailService;
use App\Services\Nextcloud\NextcloudService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

class HandleExpiredMembersDolibarr extends Command
{
    protected $signature = 'members:cleanup-expired
    {email? : Adresse email d\'un adhérent à traiter uniquement}
    {--dry-run}';

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
        $dryRun = $this->option('dry-run');
        $emailFilter = $this->argument('email');

        $this->info(
            $dryRun
                ? 'DRY-RUN activé – aucune modification ne sera effectuée'
                : 'Mode réel activé'
        );

        if ($emailFilter) {
            $this->info("Mode utilisateur unique : {$emailFilter}");
        }

        $this->info('Récupération des adhérents Dolibarr');

        $members = collect($this->dolibarr->getAllMembers());
        $today = now()->startOfDay();

        $expiredMembers = $members->filter(function ($member) use ($today) {
            if (($member['statut'] ?? null) != 1) {
                return false;
            }

            if (empty($member['datefin'])) {
                return false;
            }

            return \Carbon\Carbon::parse($member['datefin'])->lt($today);
        });

        if ($emailFilter) {
            $expiredMembers = $expiredMembers->filter(function ($member) use ($emailFilter) {
                $email = $this->extractRetzienEmail($member['email'] ?? null);
                return $email === $emailFilter;
            });

            if ($expiredMembers->isEmpty()) {
                $this->warn("Aucun adhérent expiré trouvé pour {$emailFilter}");
                return CommandAlias::SUCCESS;
            }
        }


        $this->info("{$expiredMembers->count()} adhérent(s) expiré(s)");

        foreach ($expiredMembers as $member) {
            try {
                $this->processMember($member, $dryRun);
            } catch (\Throwable $e) {
                Log::error('Erreur traitement adhérent', [
                    'member_id' => $member['id'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info(
            $dryRun
                ? 'DRY-RUN terminé – aucune action effectuée'
                : 'Traitement terminé'
        );
        return CommandAlias::SUCCESS;
    }

    /**
     * @throws ConnectionException
     */
    protected function processMember(array $member, bool $dryRun): void
    {
        $email = $this->extractRetzienEmail($member['email'] ?? null);

        $this->line("• {$member['id']} - {$email}");

        // Résiliation Dolibarr
        if ($dryRun) {
            $this->info("[DRY-RUN] Résiliation Dolibarr");
        } else {
            $this->dolibarr->setMemberStatus($member['id'], '0');
        }

        // Désactivation mail
        if ($email) {
            $this->disableMailAccount($email, $dryRun);
        }

        //  Désactivation Nextcloud
        if ($email) {
            if ($dryRun) {
                $this->info("[DRY-RUN] Désactivation Nextcloud");
            } else {
                $this->nextcloud->disableUserByEmail($email);
            }
        }
    }

    protected function disableMailAccount(string $email, bool $dryRun): void
    {
        $details = $this->mailService->getMailUserDetails($email);

        if (!$details) {
            $this->warn("Boîte mail inexistante : {$email}");
            return;
        }

        if ($dryRun) {
            $this->info("[DRY-RUN] Mail désactivé");
            return;
        }

        $this->mailService->updateMailUser($email, [
            'postfix' => 'n',
            'disablesmtp' => 'y',
            'disableimap' => 'y',
            'disablepop3' => 'y',
        ]);

        $this->info("Mail désactivé");
    }

    protected function extractRetzienEmail(?string $emails): ?string
    {
        if (!$emails) {
            return null;
        }

        return collect(explode(';', $emails))
            ->map(fn (string $email): string => trim($email))
            ->filter(fn (string $email): bool => str_contains($email, '@retzien.fr'))
            ->first();
    }
}
