<?php

namespace App\Console\Commands;

use App\Enums\IspconfigType;
use App\Models\IspconfigMember;
use App\Models\Member;
use App\Services\ISPConfig\ISPConfigWebService;
use Illuminate\Console\Command;
use function Laravel\Prompts\progress;

class SyncISPConfigWebMembers extends Command
{
    protected $signature = 'sync:ispconfig-web-members {--refresh-cache : Vider le cache avant la synchronisation}';
    protected $description = 'Synchronise les services WEB ISPConfig des membres (via member->website_url)';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        //@todo: Retrouver le client_id pour chaque adhérent

        $this->info('Synchronisation ISPConfig WEB (via member->website_url)');

        $ispWeb = new ISPConfigWebService();

        // Vider le cache si demandé
        if ($this->option('refresh-cache')) {
            $this->info('Vidage du cache ISPConfig...');
            $ispWeb->clearAllCache();
        }

        // Récupération de toutes les données ISPConfig en une seule fois (avec cache)
        $this->info('Chargement des données ISPConfig...');
        $allWebsites = collect($ispWeb->getAllWebsites());
        $allDatabases = collect($ispWeb->getAllDatabases());
        $allFtpUsers = collect($ispWeb->getAllFtpUsers());
        $allShellUsers = collect($ispWeb->getAllShellUsers());
        $allDnsZones = collect($ispWeb->getAllDnsZones());

        $progressBar = progress(
            label: 'ISPConfig Web Members import',
            steps: Member::whereNotNull('website_url')->count()
        );

        $progressBar->start();

        // Parcours des membres
        Member::whereNotNull('website_url')->chunk(100, function ($members) use (
            $allWebsites,
            $allDatabases,
            $allFtpUsers,
            $allShellUsers,
            $allDnsZones,
            $ispWeb,
            $progressBar
        ) {
            foreach ($members as $member) {

                // Extraction des domaines depuis website_url
                $memberDomains = collect(explode(';', $member->website_url))
                    ->map(fn($url) => $this->normalizeDomain($url))
                    ->filter()
                    ->unique()
                    ->values();

                if ($memberDomains->isEmpty()) {
                    $progressBar->advance();
                    continue;
                }

                // Recherche des sites ISPConfig correspondants
                $matchedWebsites = $allWebsites->filter(function ($site) use ($memberDomains, $ispWeb) {
                    $siteDomain = strtolower($site['domain']);

                    // Vérification du domaine principal
                    if ($memberDomains->contains($siteDomain)) {
                        return true;
                    }

                    // Récupération et vérification des alias (avec cache)
                    $aliases = $ispWeb->getWebsiteAliases($site['domain_id']);
                    foreach ($aliases as $alias) {
                        if ($memberDomains->contains(strtolower($alias))) {
                            return true;
                        }
                    }

                    return false;
                });

                if ($matchedWebsites->isEmpty()) {
                    $progressBar->advance();
                    continue;
                }

                // Construction des données pour chaque site
                $sitesData = $matchedWebsites->map(function ($site) use (
                    $allDatabases,
                    $allFtpUsers,
                    $allShellUsers,
                    $allDnsZones,
                    $ispWeb
                ) {
                    $domainId = $site['domain_id'];
                    $sysGroupId = $site['sys_groupid'];
                    $domain = $site['domain'];

                    // Récupération des alias (avec cache)
                    $aliases = $ispWeb->getWebsiteAliases($domainId);

                    // Filtrage des bases de données pour ce site
                    $databases = $allDatabases
                        ->filter(fn($db) => $db['sys_groupid'] == $sysGroupId)
                        ->map(fn($db) => [
                            'database_id' => $db['database_id'],
                            'database_name' => $db['database_name'],
                            'database_user_id' => $db['database_user_id'],
                            'database_type' => $db['type'],
                        ])
                        ->values();

                    // Filtrage des utilisateurs FTP pour ce site
                    $ftpUsers = $allFtpUsers
                        ->filter(fn($ftp) => $ftp['parent_domain_id'] == $domainId)
                        ->map(fn($ftp) => [
                            'ftp_user_id' => $ftp['ftp_user_id'],
                            'username' => $ftp['username'],
                            'dir' => $ftp['dir'],
                        ])
                        ->values();

                    // Filtrage des utilisateurs Shell pour ce site
                    $shellUsers = $allShellUsers
                        ->filter(fn($shell) => $shell['parent_domain_id'] == $domainId)
                        ->map(fn($shell) => [
                            'shell_user_id' => $shell['shell_user_id'],
                            'username' => $shell['username'],
                            'shell' => $shell['shell'],
                            'chroot' => $shell['chroot'],
                        ])
                        ->values();

                    // Filtrage des zones DNS pour ce site
                    // Le champ 'origin' de la zone DNS correspond au domaine avec un point final
                    $dnsZones = $allDnsZones
                        ->filter(function ($zone) use ($domain, $aliases) {
                            // Normalisation : retirer le point final de l'origin pour comparer
                            $zoneOrigin = rtrim($zone['origin'], '.');

                            // Vérifier le domaine principal
                            if (strtolower($zoneOrigin) === strtolower($domain)) {
                                return true;
                            }

                            // Vérifier les alias
                            foreach ($aliases as $alias) {
                                if (strtolower($zoneOrigin) === strtolower($alias)) {
                                    return true;
                                }
                            }

                            return false;
                        })
                        ->map(fn($zone) => [
                            'id' => $zone['id'],
                            'origin' => $zone['origin'],
                            'ns' => $zone['ns'],
                            'active' => $zone['active'],
                            'dnssec_wanted' => $zone['dnssec_wanted'] ?? null,
                            'dnssec_initialized' => $zone['dnssec_initialized'] ?? null,
                        ])
                        ->values();

                    return [
                        'domain_id' => $domainId,
                        'domain' => $domain,
                        'document_root' => $site['document_root'],
                        'active' => $site['active'],
                        'aliases' => $aliases,
                        'databases' => $databases,
                        'ftp_users' => $ftpUsers,
                        'shell_users' => $shellUsers,
                        'dns_zones' => $dnsZones,
                    ];
                });

                // Création/mise à jour d'un enregistrement par site
                foreach ($sitesData as $siteData) {
                    IspconfigMember::updateOrCreate(
                        [
                            'member_id' => $member->id,
                            'type' => IspconfigType::WEB,
                            'ispconfig_service_user_id' => $siteData['domain_id'],
                        ],
                        [
                            'data' => $siteData,
                        ]
                    );
                }

                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->info('Synchronisation WEB terminée');
    }

    /**
     * Normalise une URL vers un domaine
     */
    private function normalizeDomain(string $url): ?string
    {
        $url = trim($url);

        if (!str_starts_with($url, 'http')) {
            $url = 'https://' . $url;
        }

        $host = parse_url($url, PHP_URL_HOST);

        return $host ? strtolower($host) : null;
    }
}
