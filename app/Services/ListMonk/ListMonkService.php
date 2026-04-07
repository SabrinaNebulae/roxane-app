<?php

namespace App\Services\ListMonk;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ListMonkService
{
    protected PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::withBasicAuth(
            config('services.listmonk.username'),
            config('services.listmonk.password')
        )
            ->withHeaders(['Accept' => 'application/json'])
            ->baseUrl(config('services.listmonk.base_url'));
    }

    /**
     * Retrieve all Listmonk user accounts.
     *
     * @return array<array-key, mixed>
     *
     * @throws ConnectionException
     */
    public function getUsers(): array
    {
        return $this->http
            ->get('/users')
            ->json('data') ?? [];
    }

    /**
     * Retrieve all mailing lists with their subscriber counts.
     *
     * @return array<array-key, mixed>
     *
     * @throws ConnectionException
     */
    public function getLists(): array
    {
        return $this->http
            ->get('/lists', ['per_page' => 'all'])
            ->json('data.results') ?? [];
    }
}
