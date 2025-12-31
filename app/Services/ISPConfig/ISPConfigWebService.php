<?php

namespace App\Services\ISPConfig;

use Illuminate\Support\Facades\Cache;

class ISPConfigWebService extends ISPConfigService
{
    public function __construct()
    {
        parent::__construct('web_server');
    }

    /**
     * @throws \Exception
     */
    public function getAllWebsites(): array
    {
        return Cache::remember(
            "ispconfig.web.websites.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('sites_web_domain_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws \Exception
     */
    public function getAllDatabases(): array
    {
        return Cache::remember(
            "ispconfig.web.databases.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('sites_database_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws \Exception
     */
    public function getAllFtpUsers(): array
    {
        return Cache::remember(
            "ispconfig.web.ftp.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('sites_ftp_user_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws \Exception
     */
    public function getAllShellUsers(): array
    {
        return Cache::remember(
            "ispconfig.web.shell.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('sites_shell_user_get', ['primary_id' => -1])
        );
    }

    /**
     * @throws \Exception
     */
    public function getAllDnsZones(): array
    {
        return Cache::remember(
            "ispconfig.web.dns-zones.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('dns_zone_get', ['primary_id' => -1])
        );
    }

    /**
     * Récupère la liste des alias d'un site web
     *
     * @param int $domainId
     * @return array
     * @throws \Exception
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
                    return array_values(array_filter($aliases, fn($alias) => !empty($alias)));

                } catch (\Exception $e) {
                    \Log::error("Erreur lors de la récupération des alias pour le domaine {$domainId}: " . $e->getMessage());
                    return [];
                }
            }
        );
    }

    /**
     * Récupère la liste des bases de données d'un site en filtrant depuis toutes les BDD
     *
     * @param int $sysGroupId
     * @return array
     * @throws \Exception
     */
    public function getWebsiteDatabases(int $sysGroupId): array
    {
        // Récupération de toutes les bases de données
        $allDatabases = $this->getAllDatabases();

        // Filtrage par sys_groupid
        return collect($allDatabases)
            ->filter(fn($db) => $db['sys_groupid'] == $sysGroupId)
            ->map(fn($db) => [
                'database_id' => $db['database_id'],
                'database_name' => $db['database_name'],
                'database_user' => $db['database_user'],
                'database_type' => $db['type'],
                'active' => $db['active'],
                'remote_access' => $db['remote_access'],
                'remote_ips' => $db['remote_ips'] ?? ''
            ])
            ->values()
            ->toArray();
    }

    /**
     * Récupère la liste des utilisateurs FTP d'un site en filtrant depuis tous les comptes FTP
     *
     * @param int $domainId
     * @return array
     * @throws \Exception
     */
    public function getWebsiteFtpUsers(int $domainId): array
    {
        // Récupération de tous les utilisateurs FTP
        $allFtpUsers = $this->getAllFtpUsers();

        // Filtrage par parent_domain_id
        return collect($allFtpUsers)
            ->filter(fn($ftp) => $ftp['parent_domain_id'] == $domainId)
            ->map(fn($ftp) => [
                'ftp_user_id' => $ftp['ftp_user_id'],
                'username' => $ftp['username'],
                'dir' => $ftp['dir'],
                'quota_size' => $ftp['quota_size'],
                'active' => $ftp['active'],
                'uid' => $ftp['uid'],
                'gid' => $ftp['gid']
            ])
            ->values()
            ->toArray();
    }

    /**
     * Récupère la liste des utilisateurs Shell d'un site en filtrant depuis tous les comptes Shell
     *
     * @param int $domainId
     * @return array
     * @throws \Exception
     */
    public function getWebsiteShellUsers(int $domainId): array
    {
        // Récupération de tous les utilisateurs Shell (avec cache)
        $allShellUsers = $this->getAllShellUsers();

        // Filtrage par parent_domain_id
        return collect($allShellUsers)
            ->filter(fn($shell) => $shell['parent_domain_id'] == $domainId)
            ->map(fn($shell) => [
                'shell_user_id' => $shell['shell_user_id'],
                'username' => $shell['username'],
                'dir' => $shell['dir'],
                'shell' => $shell['shell'],
                'puser' => $shell['puser'],
                'pgroup' => $shell['pgroup'],
                'quota_size' => $shell['quota_size'],
                'active' => $shell['active'],
                'chroot' => $shell['chroot'],
                'ssh_rsa' => !empty($shell['ssh_rsa'])
            ])
            ->values()
            ->toArray();
    }

    /**
     * Récupère toutes les informations complètes d'un site (alias, BDD, FTP, Shell)
     *
     * @param int $domainId
     * @return array|null
     * @throws \Exception
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
                if (!empty($site['alias'])) {
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
                    'shell_users' => $this->getWebsiteShellUsers($domainId)
                ];
            }
        );
    }

    /**
     * Vide le cache pour un domaine spécifique
     *
     * @param int $domainId
     * @return void
     */
    public function clearDomainCache(int $domainId): void
    {
        Cache::forget("ispconfig.web.aliases.{$domainId}");
        Cache::forget("ispconfig.web.complete.{$domainId}");
    }

    /**
     * Vide tout le cache ISPConfig Web
     *
     * @return void
     */
    public function clearAllCache(): void
    {
        Cache::forget("ispconfig.web.websites.all");
        Cache::forget("ispconfig.web.databases.all");
        Cache::forget("ispconfig.web.ftp.all");
        Cache::forget("ispconfig.web.shell.all");
        Cache::forget("ispconfig.web.dns-zones.all");
        Cache::forget("ispconfig.web.domain-alias.all");
    }
}
