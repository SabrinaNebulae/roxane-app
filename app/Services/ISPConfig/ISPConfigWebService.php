<?php

namespace App\Services\ISPConfig;

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
        return $this->call('sites_web_domain_get', [['primary_id' => -1]]);
    }
}
