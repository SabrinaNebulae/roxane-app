<?php

namespace App\Services\Nextcloud;

use Illuminate\Support\Facades\Http;

class NextcloudService
{
    public function disableUserByEmail(string $email): bool
    {
        $username = $this->getUsernameFromEmail($email);

        return Http::withBasicAuth(
            config('services.nextcloud.username'),
            config('services.nextcloud.password')
        )->put(
            config('services.nextcloud.base_url') . "/ocs/v1.php/cloud/users/{$username}/disable",
            []
        )->successful();
    }

    protected function getUsernameFromEmail(string $email): string
    {
        return strstr($email, '@', true);
    }
}
