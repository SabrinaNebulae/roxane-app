<?php

namespace App\Services\Nextcloud;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NextcloudService
{
    protected PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::withBasicAuth(
            config('services.nextcloud.user'),
            config('services.nextcloud.password')
        )
            ->withHeaders([
                'OCS-APIRequest' => 'true',
                'Accept' => 'application/json',
            ])
            ->baseUrl(config('services.nextcloud.url') . '/ocs/v1.php');
    }

    /**
     * Désactive un utilisateur Nextcloud à partir de son email
     */
    public function disableUserByEmail(string $email): void
    {
        $userId = $this->findUserIdByEmail($email);

        if (!$userId) {
            Log::warning("Utilisateur Nextcloud introuvable", ['email' => $email]);
            return;
        }

        $response = $this->http->put("/cloud/users/{$userId}/disable");

        if (!$response->successful()) {
            throw new \RuntimeException("Erreur désactivation Nextcloud {$userId}");
        }
    }

    /**
     * Trouve le userId Nextcloud à partir de l’email
     */
    protected function findUserIdByEmail(string $email): ?string
    {
        $response = $this->http->get('/cloud/users');

        if (!$response->successful()) {
            throw new \RuntimeException('Erreur récupération utilisateurs Nextcloud');
        }

        $users = $response->json('ocs.data.users') ?? [];

        foreach ($users as $userId) {
            $details = $this->http->get("/cloud/users/{$userId}");

            if (
                $details->successful() &&
                ($details->json('ocs.data.email') === $email)
            ) {
                return $userId;
            }
        }

        return null;
    }
}
