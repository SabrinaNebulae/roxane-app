<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Notifications\TestMemberRenewalReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 * Test d'envoi des emails de relance de renouvellement
 *
 * Cette commande permet de tester les 4 phases de relance d'adhésion
 * en envoyant tous les emails aux adresses de test spécifiées uniquement.
 * Aucun email n'est envoyé aux vrais adhérents, aucune donnée n'est enregistrée.
 *
 * Les 4 phases testées :
 * 1. reminder_1 : 1ère relance (début décembre)
 * 2. reminder_2 : 2ème relance (mi-décembre)
 * 3. reminder_3 : 3ème relance (début janvier) + avertissement désactivation
 * 4. deactivate : Notification de désactivation (fin janvier)
 *
 * Chaque phase est espacée de 3 secondes pour garantir l'ordre d'arrivée.
 * Les sujets contiennent le préfixe [TEST].
 *
 * Utilisation :
 * - php artisan members:test-renewal-emails --test-emails=test@example.com
 * - php artisan members:test-renewal-emails --test-emails=test1@example.com --test-emails=test2@example.com
 * - php artisan members:test-renewal-emails --test-emails=test@example.com --year=2027 --limit=5
 *
 * @version 1.0.0
 */
class TestRenewalEmailsCommand extends Command
{
    protected $signature = 'members:test-renewal-emails
        {--year= : Année de renouvellement (par défaut : année suivante)}
        {--test-emails=* : Adresses email de test (séparées par des virgules)}
        {--limit=3 : Nombre d\'adhérents à traiter}';

    protected $description = 'Envoi de test des emails de relance de renouvellement';

    public function handle(): int
    {
        $year = $this->option('year') ?? now()->addYear()->year;
        $previousYear = $year - 1;
        $testEmails = $this->option('test-emails');
        $limit = (int) $this->option('limit');

        if (empty($testEmails)) {
            $this->error('Vous devez spécifier au moins une adresse email de test avec --test-emails');

            return CommandAlias::FAILURE;
        }

        $testEmails = is_array($testEmails) ? $testEmails : explode(',', $testEmails);
        $testEmails = array_map('trim', $testEmails);

        $this->info('Mode TEST activé');
        $this->info("Année de renouvellement : {$year}");
        $this->info('Destinataires de test : '.implode(', ', $testEmails));
        $this->info("Limite : {$limit} adhérent(s)");
        $this->newLine();

        $members = $this->getEligibleMembers($previousYear, $year, $limit);

        if ($members->isEmpty()) {
            $this->warn('Aucun adhérent éligible trouvé');

            return CommandAlias::SUCCESS;
        }

        $this->info("{$members->count()} adhérent(s) éligible(s) sélectionné(s)");
        $this->newLine();

        foreach ($members as $index => $member) {
            $number = $index + 1;
            $this->line("→ Adhérent #{$number} : {$member->full_name} ({$member->email})");

            $this->sendTestNotifications($member, $testEmails);

            $this->info('  ✓ 4 emails de test envoyés');
            $this->newLine();
        }

        $this->info('✓ Test terminé : '.($members->count() * 4).' emails envoyés aux testeurs');

        return CommandAlias::SUCCESS;
    }

    protected function getEligibleMembers(int $endYear, int $renewalYear, int $limit): \Illuminate\Support\Collection
    {
        $startDate = "{$endYear}-12-01";
        $endDate = "{$endYear}-12-31";

        return Member::query()
            ->with(['memberships' => fn ($q) => $q->where('status', 'active')->orderBy('end_date', 'desc')])
            ->where('status', 'valid')
            ->whereHas('memberships', function ($q) use ($startDate, $endDate) {
                $q->where('status', 'active')
                    ->whereBetween('end_date', [$startDate, $endDate]);
            })
            ->limit($limit)
            ->get();
    }

    protected function sendTestNotifications(Member $member, array $testEmails): void
    {
        $phases = [
            'reminder_1' => '1ère relance (début décembre)',
            'reminder_2' => '2ème relance (mi-décembre)',
            'reminder_3' => '3ème relance (début janvier)',
            'deactivate' => 'Notification de désactivation (fin janvier)',
        ];

        $phaseKeys = array_keys($phases);
        $lastPhaseKey = end($phaseKeys);

        foreach ($phases as $phase => $description) {
            foreach ($testEmails as $testEmail) {
                Notification::route('mail', $testEmail)
                    ->notify(new TestMemberRenewalReminderNotification($member, $phase));
            }

            $this->line("  → {$description}");

            if ($phase !== $lastPhaseKey) {
                $this->line('    ⏱ Pause de 3 secondes...');
                sleep(3);
            }
        }
    }
}
