<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use SoapClient;
use SoapFault;
use Exception;

class ISPConfigService
{
    protected ?SoapClient $client = null;
    protected ?string $sessionId = null;

    public function __construct()
    {
    }

    /**
     * ISPConfig Login
     */
    public function connect(string $type): void
    {
        // Type = 'hosting' or 'mailbox'
        $username = $username ?? config('services.ispconfig'.$type.'.username');
        $password = $password ?? config('services.ispconfig'.$type.'.password');

        try {
            $this->client = new SoapClient(null, [
                'location' => config('services.ispconfig' . $type . '.base_url'),
                'trace' => true,
                'exceptions' => true,
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ]),
            ]);

            $this->sessionId = $this->client->login($username, $password);
        } catch (SoapFault $e) {
            throw new Exception("An error occurred : " . $e->getMessage());
        }
    }

    /**
     * Get all clients
     */
    public function getAllClients(string $username = null, string $password = null): array
    {
        if (!$this->sessionId) {
            $this->connect($username, $password);
        }

        try {
            $clientIds = $this->client->client_get_all($this->sessionId);
            $clients = [];

            foreach ($clientIds as $id) {
                $details = $this->client->client_get($this->sessionId, (int)$id);
                if (!empty($details)) {
                    $clients[] = (array) $details;
                }
            }

            return $clients;
        } catch (SoapFault $e) {
            throw new Exception("An error occurred : " . $e->getMessage());
        } finally {
            $this->disconnect();
        }
    }

    /**
     * Logout
     */
    public function disconnect(): void
    {
        if ($this->client && $this->sessionId) {
            try {
                $this->client->logout($this->sessionId);
            } catch (SoapFault $e) {
                Log::info('ISP Config logout succeeded');
            }
        }
    }
}
