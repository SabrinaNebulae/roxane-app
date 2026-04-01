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
            ->baseUrl(config('services.listmonk.base_url').'/api');
    }

    // -------------------------------------------------------------------------
    // Lists
    // -------------------------------------------------------------------------

    /**
     * Retrieve all mailing lists.
     *
     * @throws ConnectionException
     */
    public function getLists(): array
    {
        return $this->http
            ->get('/lists', ['per_page' => 'all'])
            ->json('data.results') ?? [];
    }

    /**
     * Retrieve a single list by its ID.
     *
     * @throws ConnectionException
     */
    public function getList(int $listId): ?array
    {
        $response = $this->http->get("/lists/{$listId}");

        if (! $response->successful()) {
            return null;
        }

        return $response->json('data');
    }

    // -------------------------------------------------------------------------
    // Subscribers
    // -------------------------------------------------------------------------

    /**
     * Retrieve subscribers with optional pagination.
     *
     * @throws ConnectionException
     */
    public function getSubscribers(int $page = 1, int $perPage = 100): array
    {
        return $this->http
            ->get('/subscribers', [
                'page' => $page,
                'per_page' => $perPage,
            ])
            ->json('data.results') ?? [];
    }

    /**
     * Retrieve a single subscriber by their Listmonk ID.
     *
     * @throws ConnectionException
     */
    public function getSubscriber(int $subscriberId): ?array
    {
        $response = $this->http->get("/subscribers/{$subscriberId}");

        if (! $response->successful()) {
            return null;
        }

        return $response->json('data');
    }

    /**
     * Find a subscriber by their email address.
     *
     * @throws ConnectionException
     */
    public function getSubscriberByEmail(string $email): ?array
    {
        $results = $this->http
            ->get('/subscribers', ['query' => "subscribers.email = '{$email}'"])
            ->json('data.results') ?? [];

        return $results[0] ?? null;
    }

    /**
     * Create a new subscriber and enrol them in the given lists.
     *
     * @param  array<int>  $listIds  IDs of the lists to subscribe to.
     * @param  array<string, mixed>  $attribs  Custom attributes (e.g. language preference).
     *
     * @throws ConnectionException
     */
    public function createSubscriber(
        string $email,
        string $name,
        array $listIds = [],
        array $attribs = [],
        string $status = 'enabled',
    ): ?array {
        $response = $this->http->post('/subscribers', [
            'email' => $email,
            'name' => $name,
            'status' => $status,
            'lists' => $listIds,
            'attribs' => $attribs,
        ]);

        if (! $response->successful()) {
            return null;
        }

        return $response->json('data');
    }

    /**
     * Update an existing subscriber's information.
     *
     * @param  array<int>  $listIds
     * @param  array<string, mixed>  $attribs
     *
     * @throws ConnectionException
     */
    public function updateSubscriber(
        int $subscriberId,
        string $email,
        string $name,
        array $listIds = [],
        array $attribs = [],
        string $status = 'enabled',
    ): bool {
        $response = $this->http->put("/subscribers/{$subscriberId}", [
            'email' => $email,
            'name' => $name,
            'status' => $status,
            'lists' => $listIds,
            'attribs' => $attribs,
        ]);

        return $response->successful();
    }

    /**
     * Subscribe or unsubscribe a set of subscribers from lists.
     *
     * @param  array<int>  $subscriberIds
     * @param  array<int>  $listIds
     * @param  string  $action  subscribe | unsubscribe
     * @param  string  $status  confirmed | unconfirmed
     *
     * @throws ConnectionException
     */
    public function updateSubscriberLists(
        array $subscriberIds,
        array $listIds,
        string $action = 'subscribe',
        string $status = 'confirmed',
    ): bool {
        $response = $this->http->put('/subscribers/lists', [
            'ids' => $subscriberIds,
            'action' => $action,
            'status' => $status,
            'list_ids' => $listIds,
        ]);

        return $response->successful();
    }

    /**
     * Add a subscriber to the blocklist.
     *
     * @throws ConnectionException
     */
    public function blocklistSubscriber(int $subscriberId): bool
    {
        return $this->http
            ->put("/subscribers/{$subscriberId}/blocklist")
            ->successful();
    }

    /**
     * Permanently delete a subscriber.
     *
     * @throws ConnectionException
     */
    public function deleteSubscriber(int $subscriberId): bool
    {
        return $this->http
            ->delete("/subscribers/{$subscriberId}")
            ->successful();
    }

    /**
     * Send an opt-in confirmation email to a subscriber.
     *
     * @throws ConnectionException
     */
    public function sendOptin(int $subscriberId): bool
    {
        return $this->http
            ->post("/subscribers/{$subscriberId}/optin")
            ->successful();
    }
}
