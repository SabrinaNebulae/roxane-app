<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Services\MemberRenewalService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 * Processus de relances pour renouvellement d'adhésion
 *
 * Cette commande gère l'envoi automatique des 4 phases de relance aux adhérents
 * dont l'adhésion arrive à expiration. Elle est planifiée via le scheduler Laravel.
 *
 * Les 4 phases :
 * 1. reminder_1 : 1er décembre - Première relance (invitation renouvellement)
 * 2. reminder_2 : 15 décembre - Deuxième relance (rappel)
 * 3. reminder_3 : 5 janvier - Dernière relance (avertissement désactivation fin janvier)
 * 4. deactivate : 28 janvier - Désactivation des comptes non renouvelés
 *
 * Critères d'éligibilité :
 * - Membre avec status 'valid'
 * - Possède une adhésion active expirant l'année précédente
 * - Pas d'adhésion active pour l'année en cours
 * - Relance pas déjà envoyée (tracking via member_renewal_reminders)
 *
 * Modes :
 * - Mode auto : Détecte automatiquement la phase selon la date actuelle
 * - Mode manuel : Force une phase spécifique (utile pour tests ou correction)
 * - Dry-run : Simule l'exécution sans envoyer d'emails
 * - Ciblé : Traite un seul adhérent via son email
 *
 * Planification (routes/console.php) :
 * - 1er décembre à 09:00 : php artisan members:renewal-process --phase=reminder_1
 * - 15 décembre à 09:00 : php artisan members:renewal-process --phase=reminder_2
 * - 5 janvier à 09:00 : php artisan members:renewal-process --phase=reminder_3
 * - 28 janvier à 09:00 : php artisan members:renewal-process --phase=deactivate
 *
 * Utilisation :
 * - php artisan members:renewal-process (mode auto selon date)
 * - php artisan members:renewal-process --phase=reminder_1 --year=2027
 * - php artisan members:renewal-process --dry-run --phase=reminder_1
 * - php artisan members:renewal-process jane@doe.com --phase=reminder_1
 *
 * @version 1.0.0
 */
class MemberRenewalProcessCommand extends Command
{
    protected $signature = 'members:renewal-process
        {--phase=auto : Phase à exécuter (auto|reminder_1|reminder_2|reminder_3|deactivate)}
        {--year= : Année de renouvellement (par défaut : année suivante)}
        {--dry-run : Mode simulation}
        {email? : Email d\'un adhérent spécifique}';

    protected $description = 'Processus de relances pour renouvellement adhésion';

    public function __construct(
        protected MemberRenewalService $renewalService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $emailFilter = $this->argument('email');
        $phaseOption = $this->option('phase');
        $year = $this->option('year') ?? now()->addYear()->year;

        $this->info(
            $dryRun
                ? 'DRY-RUN activé – aucune modification ne sera effectuée'
                : 'Mode réel activé'
        );

        $phase = $phaseOption === 'auto' ? $this->determinePhase() : $phaseOption;

        if ($phase === null) {
            $this->warn('Mode auto : aucune phase détectée pour la date actuelle');

            return CommandAlias::SUCCESS;
        }

        $this->info("Phase détectée : {$phase}");
        $this->info("Année de renouvellement : {$year}");

        if ($emailFilter) {
            $this->warn("Mode utilisateur unique : {$emailFilter}");
        }

        $members = $this->getEligibleMembers($emailFilter);

        if ($members->isEmpty()) {
            $this->info('Aucun adhérent éligible');

            return CommandAlias::SUCCESS;
        }

        $this->info("{$members->count()} adhérent(s) à traiter");

        foreach ($members as $member) {
            try {
                $this->processMember($member, $phase, $year, $dryRun);
            } catch (\Throwable $e) {
                Log::error('Erreur traitement adhérent relance', [
                    'member_id' => $member->id,
                    'phase' => $phase,
                    'error' => $e->getMessage(),
                ]);
                $this->error("Erreur pour {$member->email} : {$e->getMessage()}");
            }
        }

        $this->info(
            $dryRun
                ? 'DRY-RUN terminé – aucune action effectuée'
                : 'Traitement terminé'
        );

        return CommandAlias::SUCCESS;
    }

    protected function determinePhase(): ?string
    {
        $today = now();

        if ($today->month === 12 && $today->day >= 1 && $today->day <= 10) {
            return 'reminder_1';
        }

        if ($today->month === 12 && $today->day >= 15 && $today->day <= 20) {
            return 'reminder_2';
        }

        if ($today->month === 1 && $today->day >= 4 && $today->day <= 6) {
            return 'reminder_3';
        }

        if ($today->month === 1 && $today->day >= 25 && $today->day <= 31) {
            return 'deactivate';
        }

        return null;
    }

    protected function getEligibleMembers(?string $emailFilter): \Illuminate\Support\Collection
    {
        $query = Member::query()
            ->where('status', 'valid')
            ->whereHas('memberships', function ($q) {
                $q->where('status', 'active');
            });

        if ($emailFilter) {
            $query->where('email', $emailFilter)
                ->orWhere('retzien_email', $emailFilter);
        }

        return $query->get();
    }

    protected function processMember(Member $member, string $phase, int $year, bool $dryRun): void
    {
        $this->line("• {$member->id} - {$member->email}");

        if ($dryRun) {
            $this->info("[DRY-RUN] Phase {$phase}");

            return;
        }

        $sent = match ($phase) {
            'reminder_1' => $this->renewalService->sendReminder1($member, $year),
            'reminder_2' => $this->renewalService->sendReminder2($member, $year),
            'reminder_3' => $this->renewalService->sendReminder3($member, $year),
            'deactivate' => $this->renewalService->deactivateMember($member, $year),
            default => false,
        };

        if ($sent) {
            $this->info('  ✓ Relance envoyée');
        } else {
            $this->warn("  → Aucune relance envoyée (Membre non concerné / mail de relance déjà envoyé / adhésion active pour {$year})");
        }
    }
}
