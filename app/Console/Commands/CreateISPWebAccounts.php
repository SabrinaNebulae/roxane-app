<?php

namespace App\Console\Commands;

use App\Enums\IspconfigType;
use App\Models\IspconfigMember;
use App\Models\Member;
use App\Services\ISPConfig\ISPConfigWebService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use function Laravel\Prompts\progress;

class CreateISPWebAccounts extends Command
{
    protected $signature = 'ext:create-isp-accounts
                            {--dry-run : Simulate without creating accounts}
                            {--force : Force recreation even if client already exists}';

    protected $description = 'Create ISPConfig clients for members and reassign their websites';

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        $isForce = $this->option('force');

        $this->info('ISPConfig Client Creation & Website Reassignment');

        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        $ispWeb = new ISPConfigWebService;

        // Récupération de tous les membres ayant un site web
        $membersQuery = Member::whereNotNull('website_url')
            ->where('website_url', '!=', '');

        $totalMembers = $membersQuery->count();

        if ($totalMembers === 0) {
            $this->info('No members with websites found');

            return self::SUCCESS;
        }

        $this->info("Found {$totalMembers} members with websites");

        // Récupération de tous les sites web depuis ISPConfig (avec cache)
        $allWebsites = collect($ispWeb->getAllWebsites());

        // Récupération des clients déjà créés dans Roxane (pour éviter les doublons)
        $existingClients = IspconfigMember::where('type', IspconfigType::WEB)
            ->whereIn('member_id', $membersQuery->pluck('id'))
            ->get()
            ->keyBy('member_id');

        $progressBar = progress(
            label: 'Processing members',
            steps: $totalMembers
        );

        $progressBar->start();

        // Statistiques de traitement
        $stats = [
            'clients_created' => 0,
            'websites_reassigned' => 0,
            'errors' => 0,
            'skipped' => 0,
        ];

        // Résultats détaillés pour le mode dry-run
        $dryRunResults = [];

        // Traitement par lots de 50 membres
        $membersQuery->chunk(50, function ($members) use (
            $ispWeb,
            $allWebsites,
            $existingClients,
            $progressBar,
            $isDryRun,
            $isForce,
            &$stats,
            &$dryRunResults
        ) {
            foreach ($members as $member) {
                try {
                    /** @var IspconfigMember|null $existingClient */
                    $existingClient = $existingClients->get($member->id);

                    // Extraction et normalisation des domaines depuis member->website_url
                    $memberDomains = $this->extractDomains($member->website_url);

                    if ($memberDomains->isEmpty()) {
                        $this->warn("No valid domains for member: {$member->full_name}");
                        $stats['skipped']++;
                        $progressBar->advance();

                        continue;
                    }

                    // Recherche des sites web ISPConfig correspondant aux domaines du membre
                    $matchedWebsites = $ispWeb->findWebsitesForDomains($allWebsites, $memberDomains);

                    if ($matchedWebsites->isEmpty()) {
                        $this->warn("No ISPConfig websites found for member: {$member->full_name}");
                        $stats['skipped']++;
                        $progressBar->advance();

                        continue;
                    }

                    $email = $member->retzien_email ?? $member->email;
                    $clientInfo = null;

                    // Vérification 1 : Le client existe-t-il dans ISPConfig ?
                    $existingIspClient = $ispWeb->findClientByEmail($email);

                    if ($existingIspClient && ! $isForce) {
                        // Client trouvé dans ISPConfig par email
                        $clientInfo = $existingIspClient;
                        $this->info("ISPConfig client found for {$member->full_name} with email {$email} (Client ID: {$clientInfo['client_id']})");
                    } elseif ($existingClient && ! $isForce && $existingClient->ispconfig_client_id > 0) {
                        // Client déjà lié dans Roxane (fallback) - uniquement si client_id valide
                        $clientInfo = [
                            'client_id' => (int) $existingClient->ispconfig_client_id,
                            'groupid' => (int) $existingClient->ispconfig_client_id,
                        ];
                        $this->info("Member {$member->full_name} already linked to ISPConfig client (ID: {$clientInfo['client_id']})");
                    }

                    if (! $isDryRun) {
                        // MODE EXECUTION RÉELLE

                        // Création du client ISPConfig si nécessaire
                        if ($clientInfo === null) {
                            $clientInfo = $this->createClient($member, $ispWeb, $email);
                            $stats['clients_created']++;
                        }

                        // Réassignation de tous les sites web au client ISPConfig
                        foreach ($matchedWebsites as $website) {
                            $domainId = $website['domain_id'];

                            $ispWeb->updateWebsiteClient($domainId, $clientInfo['groupid']);
                            $stats['websites_reassigned']++;

                            $this->info("Reassigned {$website['domain']} to client {$clientInfo['client_id']}");
                        }

                        // Sauvegarde dans Roxane de la relation membre <-> client ISPConfig
                        $siteData = $matchedWebsites->map(fn ($site) => [
                            'domain_id' => $site['domain_id'],
                            'domain' => $site['domain'],
                        ])->toArray();

                        IspconfigMember::updateOrCreate(
                            [
                                'member_id' => $member->id,
                                'type' => IspconfigType::WEB,
                            ],
                            [
                                'ispconfig_client_id' => $clientInfo['client_id'],
                                'data' => [
                                    'sites' => $siteData,
                                ],
                            ]
                        );
                    } else {
                        // MODE DRY-RUN : Collecte des informations sans modifications

                        $willCreateClient = $clientInfo === null;

                        if ($willCreateClient) {
                            $stats['clients_created']++;
                        }

                        $dryRunResults[] = [
                            'member' => $member->full_name,
                            'email' => $email,
                            'action' => $willCreateClient ? 'CREATE ISP CLIENT' : 'USE EXISTING ISP CLIENT',
                            'client_id' => $clientInfo['client_id'] ?? 'NEW',
                            'websites' => $matchedWebsites->pluck('domain')->implode(', '),
                            'sites_count' => $matchedWebsites->count(),
                        ];
                    }

                } catch (Exception $e) {
                    $this->error("Error processing {$member->full_name}: {$e->getMessage()}");
                    $stats['errors']++;
                }

                $progressBar->advance();
            }
        });

        $progressBar->finish();

        $this->newLine();
        $this->info('Summary:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Clients created', $stats['clients_created']],
                ['Websites reassigned', $stats['websites_reassigned']],
                ['Skipped', $stats['skipped']],
                ['Errors', $stats['errors']],
            ]
        );

        if ($isDryRun && ! empty($dryRunResults)) {
            $this->newLine();
            $this->info('Dry Run Details:');
            $this->table(
                ['Member', 'Email', 'Action', 'Client ID', 'Websites', 'Sites Count'],
                collect($dryRunResults)->map(fn ($r) => [
                    $r['member'],
                    $r['email'],
                    $r['action'],
                    $r['client_id'],
                    $r['websites'],
                    $r['sites_count'],
                ])
            );
        }

        return $stats['errors'] > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Extrait les domaines depuis la chaîne website_url (séparés par ;)
     * et les normalise en minuscules
     */
    private function extractDomains(string $websiteUrl): Collection
    {
        return collect(explode(';', $websiteUrl))
            ->map(fn ($url) => $this->normalizeDomain($url))
            ->filter()
            ->unique()
            ->values();
    }

    /**
     * Normalise une URL pour extraire uniquement le nom de domaine
     * Exemple: "https://www.example.com/path" → "www.example.com"
     */
    private function normalizeDomain(string $url): ?string
    {
        $url = trim($url);

        if (! str_starts_with($url, 'http')) {
            $url = 'https://'.$url;
        }

        $host = parse_url($url, PHP_URL_HOST);

        return $host ? strtolower($host) : null;
    }

    /**
     * Crée un nouveau client dans ISPConfig avec toutes les données du membre
     *
     * @throws Exception
     */
    private function createClient(Member $member, ISPConfigWebService $ispWeb, string $email): array
    {
        $username = $this->generateUsername($member);
        $password = Str::random(16);

        // Préparation des données client pour ISPConfig
        $clientData = [
            'company_name' => $member->company ?? $member->full_name,
            'contact_name' => $member->full_name,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'customer_no' => (string) $member->id,
            'street' => $member->address ?? '',
            'zip' => $member->zipcode ?? '',
            'city' => $member->city ?? '',
            'country' => $member->country ?? 'FR',
            'telephone' => $member->phone1 ?? '',
            'mobile' => $member->phone2 ?? '',
            'internet' => $member->website_url ?? '',
        ];

        // Appel API ISPConfig pour créer le client
        $clientInfo = $ispWeb->createClient($clientData);

        $this->info("Created ISPConfig client for {$member->full_name} (Client ID: {$clientInfo['client_id']})");

        return $clientInfo;
    }

    /**
     * Génère un nom d'utilisateur pour ISPConfig
     * Format: prenomnom (en minuscules, sans espaces ni accents)
     * Exemple: "jeandurand", "johndoe"
     */
    private function generateUsername(Member $member): string
    {
        $username = Str::slug($member->firstname.$member->lastname);

        return str_replace('-', '', $username);
    }
}
