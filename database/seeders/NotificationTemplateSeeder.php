<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        NotificationTemplate::updateOrCreate(
            ['identifier' => 'member_new_request_member'],
            [
                'name' => 'Nouvelle demande d\'adhésion — membre',
                'subject' => 'Votre demande d\'adhésion a bien été reçue — {app_name}',
                'body' => '<p>Bonjour {member_name},</p>'
                    .'<p>Nous avons bien reçu votre demande d\'adhésion pour la formule <strong>{package_name}</strong>.</p>'
                    .'<p>Votre dossier est en attente de validation par notre équipe. Vous recevrez un e-mail dès que votre adhésion aura été traitée.</p>'
                    .'<p>Merci pour votre confiance et bienvenue dans l\'association !</p>',
                'variables' => [
                    'member_name' => 'Nom complet du membre',
                    'package_name' => 'Nom de la formule choisie',
                    'app_name' => 'Nom de l\'application',
                ],
                'is_active' => true,
            ]
        );

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'membership_validated'],
            [
                'name' => 'Adhésion validée — membre',
                'subject' => 'Votre adhésion a été validée — {app_name}',
                'body' => '<p>Bonjour {member_name},</p>'
                    .'<p>Votre adhésion pour la formule <strong>{package_name}</strong> a été validée par notre équipe.</p>'
                    .'<p><strong>Début :</strong> {start_date}<br><strong>Fin :</strong> {end_date}</p>'
                    .'<p>Vous pouvez dès à présent accéder à vos services. Pour toute question, n\'hésitez pas à nous contacter.</p>'
                    .'<p>Merci pour votre adhésion !</p>',
                'variables' => [
                    'member_name' => 'Nom complet du membre',
                    'package_name' => 'Nom de la formule',
                    'start_date' => 'Date de début de l\'adhésion',
                    'end_date' => 'Date de fin de l\'adhésion',
                    'app_name' => 'Nom de l\'application',
                ],
                'is_active' => true,
            ]
        );

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

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'admin_invitation'],
            [
                'name' => 'Invitation administrateur',
                'subject' => 'Bienvenue sur {app_name} — Configurez votre mot de passe',
                'body' => '<p>Bonjour {name},</p>'
                    .'<p>Un administrateur a créé un compte pour vous sur {app_name}.</p>'
                    .'<p>Cliquez sur le lien ci-dessous pour configurer votre mot de passe et accéder au back office.</p>'
                    .'<p><a href="{url}">Configurer mon mot de passe</a></p>'
                    .'<p>Ce lien expire dans {expire_minutes} minutes.</p>'
                    .'<p>Si vous n\'attendiez pas cette invitation, vous pouvez ignorer cet e-mail en toute sécurité.</p>',
                'variables' => [
                    'name' => 'Nom de l\'utilisateur',
                    'url' => 'URL de configuration du mot de passe',
                    'app_name' => 'Nom de l\'application',
                    'expire_minutes' => 'Durée de validité du lien (minutes)',
                ],
                'is_active' => true,
            ]
        );

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'member_new_request_admin'],
            [
                'name' => 'Nouvelle demande d\'adhésion — admin',
                'subject' => 'Nouvelle demande d\'adhésion : {member_name}',
                'body' => '<p>Une nouvelle demande d\'adhésion a été reçue.</p>'
                    .'<p>'
                    .'<strong>Nom :</strong> {member_name}<br>'
                    .'<strong>Email :</strong> {member_email}<br>'
                    .'<strong>Téléphone :</strong> {member_phone}<br>'
                    .'<strong>Adresse :</strong> {member_address}<br>'
                    .'<strong>Formule :</strong> {package_name}<br>'
                    .'<strong>Montant :</strong> {amount} €'
                    .'</p>'
                    .'<p><a href="{membership_url}" style="display:inline-block;padding:10px 20px;background:#f48fb1;color:#000;font-weight:bold;text-decoration:none;border:3px solid #000;border-radius:6px;">Voir la demande d\'adhésion</a></p>',
                'variables' => [
                    'member_name' => 'Nom complet du membre',
                    'member_email' => 'Adresse email du membre',
                    'member_phone' => 'Téléphone du membre',
                    'member_address' => 'Adresse postale du membre',
                    'package_name' => 'Nom de la formule choisie',
                    'amount' => 'Montant de la cotisation',
                    'membership_url' => 'URL de la fiche d\'adhésion dans le back office',
                    'app_name' => 'Nom de l\'application',
                ],
                'is_active' => true,
            ]
        );

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'contact_new_request'],
            [
                'name' => 'Nouvelle demande de contact',
                'subject' => 'Nouvelle demande de contact — {app_name}',
                'body' => '<p>Une nouvelle demande de contact a été reçue.</p>'
                    .'<p><strong>Nom :</strong> {contact_name}<br>'
                    .'<strong>Email :</strong> {contact_email}<br>'
                    .'<strong>Sujet :</strong> {contact_subject}</p>'
                    .'<p><strong>Message :</strong><br>{contact_message}</p>',
                'variables' => [
                    'contact_name' => 'Nom complet de l\'expéditeur',
                    'contact_email' => 'Adresse email de l\'expéditeur',
                    'contact_subject' => 'Sujet du message',
                    'contact_message' => 'Contenu du message',
                    'app_name' => 'Nom de l\'application',
                ],
                'is_active' => true,
            ]
        );

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'member_deactivated_member'],
            [
                'name' => 'Compte membre désactivé — membre',
                'subject' => 'Votre compte {app_name} a été désactivé',
                'body' => '<p>Bonjour {member_name},</p>'
                    .'<p>Votre compte a été désactivé. Vos services associés ne sont plus accessibles.</p>'
                    .'<p>Pour toute question, n\'hésitez pas à nous contacter.</p>',
                'variables' => [
                    'member_name' => 'Nom complet du membre',
                    'app_name' => 'Nom de l\'application',
                ],
                'is_active' => true,
            ]
        );

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'member_deactivated_admin'],
            [
                'name' => 'Compte membre désactivé — admin',
                'subject' => 'Compte désactivé : {member_name}',
                'body' => '<p>Le compte du membre suivant a été désactivé.</p>'
                    .'<p><strong>Nom :</strong> {member_name}<br>'
                    .'<strong>Email :</strong> {member_email}</p>',
                'variables' => [
                    'member_name' => 'Nom complet du membre',
                    'member_email' => 'Adresse email du membre',
                    'app_name' => 'Nom de l\'application',
                ],
                'is_active' => true,
            ]
        );

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'member_renewal_reminder'],
            [
                'name' => 'Relance adhésion — générique',
                'subject' => 'Rappel concernant votre adhésion — {app_name}',
                'body' => '<p>Bonjour {member_name},</p>'
                    .'<p>Nous vous contactons au sujet de votre adhésion au sein de notre association.</p>'
                    .'<p>Si votre adhésion est arrivée à expiration ou si vous n\'avez pas encore finalisé votre inscription, '
                    .'nous vous invitons à régulariser votre situation afin de continuer à bénéficier de l\'ensemble de nos services.</p>'
                    .'<p>Pour toute question ou besoin d\'assistance, n\'hésitez pas à nous contacter.</p>'
                    .'<p>Cordialement,<br>L\'équipe {app_name}</p>',
                'variables' => [
                    'member_name' => 'Nom complet du membre',
                    'app_name' => 'Nom de l\'application',
                ],
                'is_active' => true,
            ]
        );

        NotificationTemplate::updateOrCreate(
            ['identifier' => 'admin_password_reset'],
            [
                'name' => 'Réinitialisation de mot de passe',
                'subject' => 'Réinitialiser votre mot de passe — {app_name}',
                'body' => '<p>Bonjour {name},</p>'
                    .'<p>Vous recevez cet e-mail car une demande de réinitialisation de mot de passe a été effectuée pour votre compte.</p>'
                    .'<p><a href="{url}">Réinitialiser mon mot de passe</a></p>'
                    .'<p>Ce lien expire dans {expire_minutes} minutes.</p>'
                    .'<p>Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune action supplémentaire n\'est requise.</p>',
                'variables' => [
                    'name' => 'Nom de l\'utilisateur',
                    'url' => 'URL de réinitialisation du mot de passe',
                    'app_name' => 'Nom de l\'application',
                    'expire_minutes' => 'Durée de validité du lien (minutes)',
                ],
                'is_active' => true,
            ]
        );
    }
}
