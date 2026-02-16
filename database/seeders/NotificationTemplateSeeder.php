<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        NotificationTemplate::updateOrCreate(
            ['identifier' => 'subscription_expired_phase1'],
            [
                'name' => 'Adhésion expirée - Phase 1',
                'subject' => 'Votre adhésion est expirée',
                'body' => '<p>Bonjour {member_name},</p>'
                    .'<p>Votre adhésion est arrivée à expiration le {expiry_date}.</p>'
                    .'<p>Pour continuer à profiter de nos services, merci de la renouveler.</p>'
                    .'<p>Merci pour votre confiance.</p>',
                'variables' => [
                    'member_name' => 'Nom complet du membre',
                    'expiry_date' => 'Date de fin d\'adhésion',
                ],
                'is_active' => true,
            ]
        );
    }
}
