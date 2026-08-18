<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateISPWebAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ext:create-ispweb-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer les comptes ISPWeb des membres en fonction de leur domaine';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
