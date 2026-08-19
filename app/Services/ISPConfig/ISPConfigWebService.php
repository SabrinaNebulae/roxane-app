<?php

namespace App\Services\ISPConfig;

use Exception;
use Illuminate\Support\Facades\Cache;

class ISPConfigWebService extends ISPConfigService
{
    public function __construct()
    {
        parent::__construct('web_server');
    }

    /**
     * @throws Exception
     */
    public function getAllWebsites(): array
    {
        return Cache::remember(
            'ispconfig.web.websites.all',
            config('services.ispconfig.cache_ttl'),
            fn () => $this->call('sites_web_domain_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws Exception
     */
    public function getAllDatabases(): array
    {
        return Cache::remember(
            'ispconfig.web.databases.all',
            config('services.ispconfig.cache_ttl'),
            fn () => $this->call('sites_database_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws Exception
     */
    public function getAllFtpUsers(): array
    {
        return Cache::remember(
            'ispconfig.web.ftp.all',
            config('services.ispconfig.cache_ttl'),
            fn () => $this->call('sites_ftp_user_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws Exception
     */
    public function getAllShellUsers(): array
    {
        return Cache::remember(
            'ispconfig.web.shell.all',
            config('services.ispconfig.cache_ttl'),
            fn () => $this->call('sites_shell_user_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws Exception
     */
    public function getAllDnsZones(): array
    {
        return Cache::remember(
            'ispconfig.web.dns-zones.all',
            config('services.ispconfig.cache_ttl'),
            fn () => $this->call('dns_zone_get', ['primary_id' => -1])
        );
    }

    /**
     * Récupère la liste des alias d'un site web
     *
     * @throws Exception
     */
    public function getWebsiteAliases(int $domainId): array
    {
        return Cache::remember(
            "ispconfig.web.aliases.{$domainId}",
            config('services.ispconfig.cache_ttl', 3600),
            function () use ($domainId) {
                try {
                    $siteInfo = $this->call('sites_web_domain_get', ['domain_id' => $domainId]);

                    if (empty($siteInfo)) {
                        return [];
                    }

                    $site = $siteInfo;

                    if (empty($site['alias'])) {
                        return [];
                    }

                    $aliases = array_map('trim', explode(',', $site['alias']));

                    return array_values(array_filter($aliases, fn ($alias) => ! empty($alias)));

                } catch (Exception $e) {
                    \Log::error("Erreur lors de la récupération des alias pour le domaine {$domainId}: ".$e->getMessage());

                    return [];
                }
            }
        );
    }

    /**
     * Récupère la liste des bases de données d'un site en filtrant depuis toutes les BDD
     *
     * @todo : utiliser plutôt domainId => parent_domain_id
     *
     * @throws Exception
     */
    public function getWebsiteDatabases(int $sysGroupId): array
    {
        // Récupération de toutes les bases de données
        $allDatabases = $this->getAllDatabases();

        // Filtrage par sys_groupid
        return collect($allDatabases)
            ->filter(fn ($db) => $db['sys_groupid'] == $sysGroupId)
            ->map(fn ($db) => [
                'database_id' => $db['database_id'],
                'database_name' => $db['database_name'],
                'database_user' => $db['database_user'],
                'database_type' => $db['type'],
                'active' => $db['active'],
                'remote_access' => $db['remote_access'],
                'remote_ips' => $db['remote_ips'] ?? '',
            ])
            ->values()
            ->toArray();
    }

    /**
     * Récupère la liste des utilisateurs FTP d'un site en filtrant depuis tous les comptes FTP
     *
     * @throws Exception
     */
    public function getWebsiteFtpUsers(int $domainId): array
    {
        // Récupération de tous les utilisateurs FTP
        $allFtpUsers = $this->getAllFtpUsers();

        // Filtrage par parent_domain_id
        return collect($allFtpUsers)
            ->filter(fn ($ftp) => $ftp['parent_domain_id'] == $domainId)
            ->map(fn ($ftp) => [
                'ftp_user_id' => $ftp['ftp_user_id'],
                'username' => $ftp['username'],
                'dir' => $ftp['dir'],
                'quota_size' => $ftp['quota_size'],
                'active' => $ftp['active'],
                'uid' => $ftp['uid'],
                'gid' => $ftp['gid'],
            ])
            ->values()
            ->toArray();
    }

    /**
     * Récupère la liste des utilisateurs Shell d'un site en filtrant depuis tous les comptes Shell
     *
     * @throws Exception
     */
    public function getWebsiteShellUsers(int $domainId): array
    {
        // Récupération de tous les utilisateurs Shell (avec cache)
        $allShellUsers = $this->getAllShellUsers();

        // Filtrage par parent_domain_id
        return collect($allShellUsers)
            ->filter(fn ($shell) => $shell['parent_domain_id'] == $domainId)
            ->map(fn ($shell) => [
                'shell_user_id' => $shell['shell_user_id'],
                'username' => $shell['username'],
                'dir' => $shell['dir'],
                'shell' => $shell['shell'],
                'puser' => $shell['puser'],
                'pgroup' => $shell['pgroup'],
                'quota_size' => $shell['quota_size'],
                'active' => $shell['active'],
                'chroot' => $shell['chroot'],
                'ssh_rsa' => ! empty($shell['ssh_rsa']),
            ])
            ->values()
            ->toArray();
    }

    /**
     * Récupère toutes les informations complètes d'un site (alias, BDD, FTP, Shell)
     *
     * @throws Exception
     */
    public function getWebsiteCompleteInfo(int $domainId): ?array
    {
        return Cache::remember(
            "ispconfig.web.complete.{$domainId}",
            config('services.ispconfig.cache_ttl', 3600),
            function () use ($domainId) {
                $siteInfo = $this->call('sites_web_domain_get', ['domain_id' => $domainId]);

                if (empty($siteInfo)) {
                    return null;
                }

                $site = $siteInfo;

                // Récupérer les alias
                $aliases = [];
                if (! empty($site['alias'])) {
                    $aliases = array_values(array_filter(array_map('trim', explode(',', $site['alias']))));
                }

                return [
                    'domain_id' => $site['domain_id'],
                    'domain' => $site['domain'],
                    'document_root' => $site['document_root'],
                    'active' => $site['active'],
                    'sys_groupid' => $site['sys_groupid'],
                    'aliases' => $aliases,
                    'databases' => $this->getWebsiteDatabases($domainId, $site['sys_groupid']),
                    'ftp_users' => $this->getWebsiteFtpUsers($domainId),
                    'shell_users' => $this->getWebsiteShellUsers($domainId),
                ];
            }
        );
    }

    /**
     * Vide le cache pour un domaine spécifique
     */
    public function clearDomainCache(int $domainId): void
    {
        Cache::forget("ispconfig.web.aliases.{$domainId}");
        Cache::forget("ispconfig.web.complete.{$domainId}");
    }

    /**
     * Vide tout le cache ISPConfig Web
     */
    public function clearAllCache(): void
    {
        Cache::forget('ispconfig.web.websites.all');
        Cache::forget('ispconfig.web.databases.all');
        Cache::forget('ispconfig.web.ftp.all');
        Cache::forget('ispconfig.web.shell.all');
        Cache::forget('ispconfig.web.dns-zones.all');
        Cache::forget('ispconfig.web.domain-alias.all');
    }

    /**
     * Find websites matching given domains (including aliases)
     */
    public function findWebsitesForDomains(\Illuminate\Support\Collection $allWebsites, \Illuminate\Support\Collection $domains): \Illuminate\Support\Collection
    {
        return $allWebsites->filter(function ($site) use ($domains) {
            $siteDomain = strtolower($site['domain']);

            if ($domains->contains($siteDomain)) {
                return true;
            }

            $aliases = $this->getWebsiteAliases($site['domain_id']);
            foreach ($aliases as $alias) {
                if ($domains->contains(strtolower($alias))) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * Find a client by email using sys_groupid from existing websites
     * Since ISPConfig API doesn't provide a direct way to search clients by email,
     * we search through websites to find the sys_groupid (client group)
     *
     * @throws Exception
     */
    public function findClientByEmail(string $email): ?array
    {
        $allWebsites = $this->getAllWebsites();
        $normalizedEmail = strtolower(trim($email));

        foreach ($allWebsites as $website) {
            $sysGroupId = $website['sys_groupid'] ?? null;
            $systemGroup = $website['system_group'] ?? null;

            if (! $sysGroupId || ! $systemGroup) {
                continue;
            }

            try {
                $clientData = $this->call('client_get_by_groupid', [$sysGroupId]);

                if (! empty($clientData) && isset($clientData['email'])) {
                    if (strtolower(trim($clientData['email'])) === $normalizedEmail) {
                        return [
                            'client_id' => $clientData['client_id'] ?? $sysGroupId,
                            'groupid' => $sysGroupId,
                            'system_group' => $systemGroup,
                            'email' => $clientData['email'],
                        ];
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }

        return null;
    }

    /**
     * Create a new ISPConfig client
     * Returns an array with client_id and groupid
     *
     * @throws Exception
     */
    public function createClient(array $clientData): array
    {
        $resellerId = 1;

        $defaultParams = [
            'limit_maildomain' => -1,
            'limit_mailbox' => -1,
            'limit_mailalias' => -1,
            'limit_mailaliasdomain' => -1,
            'limit_mailforward' => -1,
            'limit_mailcatchall' => -1,
            'limit_mailrouting' => 0,
            'limit_mail_wblist' => 0,
            'limit_mailfilter' => -1,
            'limit_fetchmail' => -1,
            'limit_mailquota' => -1,
            'limit_spamfilter_wblist' => 0,
            'limit_spamfilter_user' => 0,
            'limit_spamfilter_policy' => 1,
            'default_webserver' => 1,
            'limit_web_ip' => '',
            'limit_web_domain' => -1,
            'limit_web_quota' => -1,
            'web_php_options' => 'no,fast-cgi,cgi,mod,suphp',
            'limit_web_subdomain' => -1,
            'limit_web_aliasdomain' => -1,
            'limit_ftp_user' => -1,
            'limit_shell_user' => 0,
            'ssh_chroot' => 'no,jailkit,ssh-chroot',
            'limit_webdav_user' => 0,
            'default_dnsserver' => 1,
            'limit_dns_zone' => -1,
            'limit_dns_slave_zone' => -1,
            'limit_dns_record' => -1,
            'default_dbserver' => 1,
            'limit_database' => -1,
            'limit_cron' => 0,
            'limit_cron_type' => 'url',
            'limit_cron_frequency' => 5,
            'limit_traffic_quota' => -1,
            'limit_client' => 0,
            'parent_client_id' => 0,
            'language' => 'fr',
            'usertheme' => 'default',
            'template_master' => 0,
            'template_additional' => '',
            'created_at' => 0,
            'default_mailserver' => 1,
        ];

        $params = array_merge($defaultParams, $clientData);

        $clientId = $this->call('client_add', [$resellerId, $params]);

        $client = $this->call('client_get', [(int) $clientId]);

        $this->clearAllCache();

        return [
            'client_id' => (int) $clientId,
            'groupid' => (int) ($client['groupid'] ?? $clientId),
            'system_group' => 'client'.$clientId,
        ];
    }

    /**
     * Update website to assign it to a different client
     *
     * @throws Exception
     */
    public function updateWebsiteClient(int $domainId, int $newClientId): bool
    {
        $websiteRecord = $this->call('sites_web_domain_get', ['domain_id' => $domainId]);

        if (! is_array($websiteRecord) || empty($websiteRecord)) {
            throw new \RuntimeException("Website with domain_id {$domainId} not found");
        }

        // sys_groupid n'est pas trouvable dans les données client
        // $websiteRecord['sys_groupid'] = $newClientId;
        $websiteRecord['system_group'] = 'client'.$newClientId;

        $result = $this->call('sites_web_domain_update', [
            0,
            $domainId,
            $websiteRecord,
        ]);

        $this->clearAllCache();

        return (bool) $result;
    }
}
