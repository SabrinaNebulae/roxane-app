<?php

namespace App\Services\Dolibarr;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class DolibarrService
{
    protected string $baseUrl;
    protected string $htaccessUrl;
    protected string $username;
    protected string $password;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.dolibarr.base_url');
        $this->htaccessUrl = config('services.dolibarr.htaccess_url');
        $this->username = config('services.dolibarr.username');
        $this->password = config('services.dolibarr.password');
        $this->apiKey   = config('services.dolibarr.api_key');
    }

    /**
     * Create an authenticated HTTP client for Dolibarr
     */
    protected function client(): PendingRequest
    {
        return Http::withBasicAuth($this->username, $this->password)
            ->withHeaders([
                'Accept'     => 'application/json',
                'DOLAPIKEY'  => $this->apiKey,
            ]);
    }

    /**
     * Get all members
     * @throws ConnectionException
     */
    public function getAllMembers(int $limit = 400, string $sortField = 't.rowid', string $sortOrder = 'ASC'): array
    {
        $response = $this->client()->get($this->baseUrl . '/members', [
            'sortfield' => $sortField,
            'sortorder' => $sortOrder,
            'limit'     => $limit,
        ]);

        return $response->json();
    }

    /**
     * Get member subscriptions
     * @throws ConnectionException
     */
    public function getMemberSubscriptions(int|string $id): array
    {
        $response = $this->client()->get($this->baseUrl . '/members/'. $id . '/subscriptions');

        return $response->json();
    }

    /**
     * Update a member with custom data
     *
     * @param int|string $id The Dolibarr member ID (rowid)
     * @param array $data Array of attributes to update (e.g. ['email' => 'new@email.com', 'array_options' => ['options_custom' => 'val']])
     * @throws ConnectionException
     */
    public function updateMember(int|string $id, array $data): bool
    {
        $response = $this->client()->put(
            $this->baseUrl . '/members/' . $id,
            $data
        );

        return $response->successful();
    }


}
