<?php

namespace App\Console\Commands;

use App\Enums\IspconfigType;
use App\Models\IspconfigMember;
use App\Models\Member;
use App\Services\ISPConfig\ISPConfigMailService;
use Illuminate\Console\Command;

use function Laravel\Prompts\progress;

class SyncISPConfigMailMembers extends Command
{
    protected $signature = 'sync:ispconfig-mail-members';

    protected $description = 'Synchronise les services MAIL ISPConfig des membres - Email Retzien';

    public function handle(): void
    {
        $this->info('Synchronisation ISPConfig MAIL');

        $ispMail = new ISPConfigMailService;

        // Récupération de tous les mail users
        $mailUsers = collect($ispMail->getAllMailUsers());

        $progressBar = progress(label: 'ISPConfig Mail Members import', steps: $mailUsers->count());
        $progressBar->start();

        $emailToMailUserId = $mailUsers
            ->filter(fn ($u) => isset($u['email'], $u['mailuser_id']))
            ->mapWithKeys(fn ($u) => [
                strtolower($u['email']) => (int) $u['mailuser_id'],
            ]);

        $synced = 0;

        // Parcours des membres
        Member::whereNotNull('retzien_email')->where('retzien_email', '!=', '')->chunk(100, function ($members) use (
            $progressBar,
            $emailToMailUserId,
            $ispMail,
            &$synced
        ) {
            foreach ($members as $member) {
                $retzienEmail = strtolower($member->retzien_email);

                if (! $retzienEmail) {
                    continue;
                }

                $mailUserId = $emailToMailUserId->get($retzienEmail);

                if (! $mailUserId) {
                    $this->warn("Aucun mail user ISPConfig pour {$retzienEmail}");

                    continue;
                }

                // Récupération des données complètes de la boîte mail
                $mailUserData = $ispMail->getMailUserDetails($retzienEmail);

                // Création / mise à jour
                IspconfigMember::updateOrCreate(
                    [
                        'member_id' => $member->id,
                        // @todo : 'ispconfig_client_id' => ?,
                        'type' => IspconfigType::MAIL,
                        'email' => $retzienEmail,
                    ],
                    [
                        'ispconfig_service_user_id' => $mailUserId,
                        'data' => [
                            // @todo: traiter plus tard le cas de plusieurs mail pour un adhérent
                            'mailuser' => [$mailUserData],
                        ],
                    ]
                );
                $synced++;
                $progressBar->advance();
            }
        });

        $progressBar->finish();
        $this->info("{$synced} services mail synchronisés");
    }
}
