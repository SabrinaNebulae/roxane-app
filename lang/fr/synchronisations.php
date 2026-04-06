<?php

return [
    'title' => 'Synchronisations',
    'navigation_label' => 'Synchronisations',

    'sections' => [
        'dolibarr' => [
            'heading' => 'Dolibarr',
            'description' => 'Importe les membres et cotisations depuis Dolibarr.',
            'action_label' => 'Synchroniser Dolibarr',
            'modal_heading' => 'Synchronisation Dolibarr',
            'modal_description' => 'Importer les membres et cotisations depuis Dolibarr.',
        ],
        'expired' => [
            'heading' => 'Membres expirés',
            'description' => 'Désactive les membres expirés dans Dolibarr, ISPConfig et Nextcloud.',
            'action_label' => 'Membres expirés',
            'modal_heading' => 'Désactiver les membres expirés',
            'modal_description' => 'Désactive les membres expirés dans Dolibarr, ISPConfig et Nextcloud.',
            'dry_run_label' => 'Mode simulation (dry-run)',
            'dry_run_helper' => 'Simule l\'opération sans effectuer de modifications.',
        ],
        'ispconfig_mail' => [
            'heading' => 'ISPConfig Mail',
            'description' => 'Lie les membres à leurs comptes mail ISPConfig (@retzien.fr).',
            'action_label' => 'ISPConfig Mail',
            'modal_heading' => 'Synchronisation ISPConfig Mail',
            'modal_description' => 'Lie les membres à leurs comptes mail ISPConfig (@retzien.fr).',
        ],
        'ispconfig_web' => [
            'heading' => 'ISPConfig Web',
            'description' => 'Lie les membres à leurs comptes d\'hébergement web.',
            'action_label' => 'ISPConfig Web',
            'modal_heading' => 'Synchronisation ISPConfig Web',
            'modal_description' => 'Lie les membres à leurs comptes d\'hébergement web.',
            'refresh_cache_label' => 'Vider le cache ISPConfig',
            'refresh_cache_helper' => 'Vide le cache avant la synchronisation.',
        ],
        'nextcloud' => [
            'heading' => 'Nextcloud',
            'description' => 'Lie les membres à leurs comptes Nextcloud.',
            'action_label' => 'Nextcloud',
            'modal_heading' => 'Synchronisation Nextcloud',
            'modal_description' => 'Lie les membres à leurs comptes Nextcloud.',
            'dry_run_label' => 'Mode simulation (dry-run)',
            'dry_run_helper' => 'Simule l\'opération sans effectuer de modifications.',
        ],
        'services' => [
            'heading' => 'Services membres',
            'description' => 'Synchronise les services associés aux membres actifs.',
            'action_label' => 'Services membres',
            'modal_heading' => 'Synchronisation des services',
            'modal_description' => 'Synchronise les services associés aux membres actifs.',
        ],
    ],

    'status' => [
        'pending' => 'En attente dans la file d\'exécution...',
        'running' => 'Exécution en cours...',
        'finished_at' => 'Terminé à :time',
    ],

    'action' => [
        'submit' => 'Lancer',
    ],
];
