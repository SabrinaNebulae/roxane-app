<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 * Export des adhérents éligibles aux relances de renouvellement en CSV
 *
 * Cette commande extrait la liste des adhérents dont l'adhésion se termine
 * en décembre de l'année précédant l'année de renouvellement cible.
 * Les données sont exportées dans un fichier CSV dans storage/app/.
 *
 * Critères d'éligibilité :
 * - Membre avec status 'valid'
 * - Possède une adhésion active se terminant en décembre de l'année N-1
 * - N'a pas encore d'adhésion active pour l'année N
 *
 * Utilisation :
 * - php artisan members:export-eligible-renewals
 * - php artisan members:export-eligible-renewals --year=2027
 * - php artisan members:export-eligible-renewals --year=2027 --output=relances.csv
 *
 * @version 1.0.0
 */
class ExportEligibleRenewalsCommand extends Command
{
    protected $signature = 'members:export-eligible-renewals
        {--year= : Année de renouvellement (par défaut : année suivante)}
        {--output=eligible_renewals.csv : Nom du fichier de sortie CSV}';

    protected $description = 'Export des adhérents éligibles aux relances de renouvellement en CSV';

    public function handle(): int
    {
        $year = $this->option('year') ?? now()->addYear()->year;
        $output = $this->option('output');
        $previousYear = $year - 1;

        $this->info("Export des adhérents dont l'adhésion se termine en décembre {$previousYear}");
        $this->info("Année de renouvellement cible : {$year}");

        $members = $this->getEligibleMembers($previousYear, $year);

        if ($members->isEmpty()) {
            $this->warn('Aucun adhérent éligible trouvé');

            return CommandAlias::SUCCESS;
        }

        $this->info("{$members->count()} adhérent(s) éligible(s) trouvé(s)");

        $this->exportToCsv($members, $output);

        $this->info("✓ Export terminé : {$output}");

        return CommandAlias::SUCCESS;
    }

    protected function getEligibleMembers(int $endYear, int $renewalYear): \Illuminate\Support\Collection
    {
        $startDate = "{$endYear}-12-01";
        $endDate = "{$endYear}-12-31";

        return Member::query()
            ->with(['memberships' => fn ($q) => $q->where('status', 'active')->orderBy('end_date', 'desc')])
            ->where('status', 'valid')
            ->whereHas('memberships', function ($q) use ($startDate, $endDate, $renewalYear) {
                $q->where('status', 'active')
                    ->whereBetween('end_date', [$startDate, $endDate])
                    ->whereDoesntHave('member.memberships', function ($subQuery) use ($renewalYear) {
                        $renewalStart = "{$renewalYear}-01-01";
                        $subQuery->where('status', 'active')
                            ->where('start_date', '>=', $renewalStart);
                    });
            })
            ->get()
            ->map(function (Member $member) {
                $lastMembership = $member->memberships->first();

                return [
                    'id' => $member->id,
                    'firstname' => $member->firstname,
                    'lastname' => $member->lastname,
                    'email' => $member->email,
                    'retzien_email' => $member->retzien_email,
                    'membership_end_date' => $lastMembership?->end_date,
                    'package_name' => $lastMembership?->package?->name ?? 'N/A',
                ];
            });
    }

    protected function exportToCsv(\Illuminate\Support\Collection $members, string $filename): void
    {
        $output = storage_path("app/{$filename}");

        $file = fopen($output, 'w');

        fputcsv($file, ['id', 'firstname', 'lastname', 'email', 'retzien_email', 'membership_end_date', 'package_name']);

        foreach ($members as $member) {
            fputcsv($file, $member);
        }

        fclose($file);
    }
}
