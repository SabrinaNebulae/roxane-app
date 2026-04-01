<?php

return [
    'fields' => [
        'member' => 'un adhérent',
        'members' => 'Adhérents',
        'keycloak_id' => 'ID Keycloak',
        'status' => 'Statut',
        'draft' => 'Brouillon',
        'valid' => 'Valide',
        'pending' => 'En attente',
        'cancelled' => 'Résilié',
        'excluded' => 'Exclu',
        'active' => 'Actif',
        'inactive' => 'Inactif',
        'nature' => 'Nature',
        'physical' => 'Physique',
        'legal' => 'Morale',
        'group_id' => 'Groupe',
        'lastname' => 'Nom',
        'firstname' => 'Prénom',
        'email' => 'Adresse e-mail',
        'company' => 'Entreprise',
        'date_of_birth' => 'Date de naissance',
        'address' => 'Adresse',
        'zipcode' => 'Code postal',
        'city' => 'Ville',
        'country' => 'Pays',
        'phone1' => 'Téléphone fixe',
        'phone2' => 'Téléphone portable',
        'public_membership' => 'Adhésion publique',
        'created_at' => 'Créé le',
        'updated_at' => 'Mis à jour le',
        'deleted_at' => 'Supprimé le',
        'widgets' => [
            'stats' => [
                'name' => 'Nouveaux Membres',
                'description' => 'Nombre de nouveaux membres par an',
            ],
        ],
    ],

    'tabs' => [
        'general_info' => 'Informations générales',
        'modules' => 'Modules',
    ],

    'sections' => [
        'personal_info' => 'Informations personnelles',
        'administrative_info' => 'Informations administratives',
        'contact_info' => 'Coordonnées',
        'status' => 'Statut',
        'actions' => 'Actions',
        'ispconfig_mail' => 'Messagerie ISPConfig',
        'ispconfig_web' => 'Hébergements Web',
        'nextcloud' => 'NextCloud',
    ],

    'ispconfig' => [
        'mail_data' => 'Données ISPConfig Mail',
        'web_data' => 'Données ISPConfig Web',
        'nextcloud_data' => 'Données NextCloud',
        'email' => 'Adresse email',
        'id' => 'ID ISPConfig',
        'quota' => 'Quota',
        'domain' => 'Domaine',
        'state' => 'État',
        'enabled' => 'Activé',
        'disabled' => 'Désactivé',
        'nextcloud_id' => 'Id Nextcloud',
        'display_name' => 'Nom de l\'utilisateur',
    ],

    'actions' => [
        'send_payment_mail' => 'Envoyer le mail de paiement',
        'send_renewal_mail' => 'Envoyer un mail de relance',
    ],
];
