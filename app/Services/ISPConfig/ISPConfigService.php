<?php

namespace App\Services\ISPConfig;

use Exception;
use Illuminate\Support\Facades\Cache;
use SoapClient;
use SoapFault;
use Illuminate\Support\Facades\Log;

class ISPConfigService
{
    protected ?SoapClient $client = null;
    protected ?string $sessionId = null;
    protected array $config;
    protected string $serverType;

    /**
     * @throws Exception
     */
    public function __construct(string $serverType = 'mail_server')
    {
        $this->serverType = $serverType;
        $this->config = config("services.ispconfig.servers.{$serverType}");

        if (!$this->config) {
            throw new Exception("ISPConfig server configuration not found for: {$serverType}");
        }
    }

    protected function connect(): void
    {
        if ($this->client !== null && $this->sessionId !== null) {
            return;
        }

        try {
            $this->client = new SoapClient(null, [
                'location' => $this->config['soap_location'],
                'uri' => $this->config['soap_uri'],
                'trace' => 1,
                'exceptions' => 1,
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ]
                ])
            ]);

            $this->sessionId = $this->client->login(
                $this->config['username'],
                $this->config['password']
            );

            Log::info("ISPConfig connected", [
                'server' => $this->serverType,
                'session_id' => $this->sessionId
            ]);

        } catch (SoapFault $e) {
            Log::error("ISPConfig connection failed", [
                'server' => $this->serverType,
                'error' => $e->getMessage()
            ]);
            throw new Exception("Failed to connect to ISPConfig: " . $e->getMessage());
        }
    }

    public function disconnect(): void
    {
        if ($this->client && $this->sessionId) {
            try {
                $this->client->logout($this->sessionId);
                Log::info("ISPConfig disconnected", ['server' => $this->serverType]);
            } catch (SoapFault $e) {
                Log::warning("ISPConfig logout failed", [
                    'server' => $this->serverType,
                    'error' => $e->getMessage()
                ]);
            }

            $this->sessionId = null;
            $this->client = null;
        }
    }

    /**
     * @throws Exception
     */
    protected function call(string $method, array $params = []): mixed
    {
        $this->connect();

        try {
            array_unshift($params, $this->sessionId);

            $result = $this->client->__soapCall($method, $params);

            Log::debug("ISPConfig API call", [
                'method' => $method,
                'server' => $this->serverType,
                'success' => true
            ]);

            return $result;

        } catch (SoapFault $e) {
            Log::error("ISPConfig API call failed", [
                'method' => $method,
                'server' => $this->serverType,
                'error' => $e->getMessage()
            ]);
            throw new Exception("ISPConfig API call failed: " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * Récupère tous les clients
     */
    public function getAllClients(): array
    {
        return Cache::remember(
            "ispconfig.mail.clients.all",
            config('services.ispconfig.cache_ttl'),
            fn() => $this->call('client_get_all')
        );
    }

    public function getClientData(string $clientId): array
    {
        return $this->call('client_get', ['client_id' => $clientId]);
    }
}
