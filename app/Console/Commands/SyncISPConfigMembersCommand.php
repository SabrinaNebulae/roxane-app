<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Services\ISPConfig\ISPConfigMailService;
use App\Services\ISPConfig\ISPConfigWebService;
use Illuminate\Console\Command;

class SyncISPConfigMembersCommand extends Command
{
    protected $signature = 'sync:ispconfig-members';

    protected $description = 'Synchronise les membres avec les clients ISPConfig Mail';

    public function handle(): void
    {
        $this->info('Début de la synchronisation ISPConfig Mail');

        $ispConfigMailService = new ISPConfigMailService();

        // TESTS
        /*$ispConfigWebService = new ISPConfigWebService();

        $webClients = [];

        $allWebClients = collect($ispConfigWebService->getAllClients());

        foreach ($allWebClients as $wclientId)
        {
            $webClients[] = $ispConfigWebService->getClientData($wclientId);
        }

        dd($webClients);

        $allClients = collect($ispConfigMailService->getAllClients());

        $clients = [];

        foreach ($allClients as $clientId) {
            $clients[] = $ispConfigMailService->getClientData($clientId);
        }

        dd($clients);*/

        // Récupération de tous les utilisateurs mail ISPConfig
        $mailUsers = collect($ispConfigMailService->getAllMailUsers());

        dd($mailUsers);
        // Construction d'une map email => mailuser_id (!= client_id car indispo via API ISP)
        $emailToClientId = $mailUsers
            ->filter(fn ($user) => isset($user['email'], $user['mailuser_id']))
            ->mapWithKeys(fn ($user) => [
                strtolower($user['email']) => (int) $user['mailuser_id']
            ]);

        dd($emailToClientId);

        // Tableau des changements
        $membersAddedOrUpdated = [];

        // Parcours des members
        Member::query()
            ->whereNotNull('email')
            ->chunk(100, function ($members) use ($emailToClientId) {
                foreach ($members as $member) {

                    // Emails séparés par ;
                    $emails = array_map('trim', explode(';', $member->email));

                    // On récupère uniquement l'email @retzien.fr
                    $retzienEmail = collect($emails)
                        ->first(fn ($email) => str_ends_with(strtolower($email), '@retzien.fr'));

                    if (!$retzienEmail) {
                        continue;
                    }

                    $retzienEmail = strtolower($retzienEmail);

                    // Recherche du client ISPConfig correspondant
                    $clientId = $emailToClientId->get($retzienEmail);

                    if (!$clientId) {
                        $this->warn("Client ISPConfig non trouvé pour {$retzienEmail}");
                        continue;
                    }

                    // Mise à jour si nécessaire
                    if ($member->ispconfig_mail_client_id !== $clientId) {

                        // Debug => Ajout au tableau des modifs
                        $membersAddedOrUpdated[] = [
                            'member_id' => $member->id,
                            'isp_id' => $clientId
                        ];

                        //$member->update([
                            //'ispconfig_mail_client_id' => $clientId,
                        //]);

                        //$this->info("Member {$member->id} synchronisé → client ISPConfig {$clientId}");
                    }
                }
            });

        // Debug
        dd($membersAddedOrUpdated);

        $this->info('Synchronisation ISPConfig Mail terminée');
    }
}
