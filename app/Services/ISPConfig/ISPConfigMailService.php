<?php

namespace App\Services\ISPConfig;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ISPConfigMailService extends ISPConfigService
{
    public function __construct()
    {
        parent::__construct('mail_server');
    }

    /**
     * Récupère tous les domaines mail
     */
    public function getAllMailDomains(): array
    {
        return Cache::remember(
            "ispconfig.mail.domains.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('mail_domain_get', ['primary_id' => -1])
        );
    }

    /**
     * Récupère tous les utilisateurs mail
     */
    public function getAllMailUsers(): array
    {
        return Cache::remember(
            "ispconfig.mail.users.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('mail_user_get', ['primary_id' => -1])
        );
    }

    /**
     * Récupère les domaines mail d'un client ISPConfig
     */
    public function getMailDomainsForClient(int $ispConfigClientId): Collection
    {
        $allDomains = $this->getAllMailDomains();

        return collect($allDomains)->filter(function ($domain) use ($ispConfigClientId) {
            return isset($domain['sys_groupid']) && $domain['sys_groupid'] == $ispConfigClientId;
        });
    }

    /**
     * Récupère les boîtes mail pour un domaine
     */
    public function getMailUsersForDomain(string $domain): Collection
    {
        $allUsers = $this->getAllMailUsers();

        return collect($allUsers)->filter(function ($user) use ($domain) {
            return str_ends_with($user['email'], '@' . $domain);
        });
    }

    /**
     * Récupère les détails d'une boîte mail
     */
    public function getMailUserDetails(string $email): ?array
    {
        $allUsers = $this->getAllMailUsers();

        $user = collect($allUsers)->firstWhere('email', $email);

        if (!$user) {
            return null;
        }

        return [
            'email' => $user['email'],
            'name' => $user['name'] ?? '',
            'quota' => (int) ($user['quota'] ?? 0),
            'usage' => (int) ($user['maildir_usage'] ?? 0),
            'usage_mb' => round(($user['maildir_usage'] ?? 0) / 1024 / 1024, 2),
            'active' => $user['postfix'] === 'y',
            'imap_enabled' => $user['disableimap'] === 'n',
            'pop3_enabled' => $user['disablepop3'] === 'n',
            'smtp_enabled' => $user['disablesmtp'] === 'n',
            'autoresponder' => $user['autoresponder'] === 'y',
            'spam_filter' => $user['move_junk'] === 'y',
        ];
    }

    public function updateMailUser(string $email, array $changes): bool
    {
        $allUsers = $this->getAllMailUsers();
        $user = collect($allUsers)->firstWhere('email', $email);

        if (!$user) {
            return false;
        }

        return $this->call('mail_user_update', [
            'primary_id' => $user['mailuser_id'],
            'params' => $changes,
        ]);
    }

}
