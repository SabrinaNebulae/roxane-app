<?php

return [
    'title' => 'Synchronisations',
    'navigation_label' => 'Synchronisations',

    'sections' => [
        'dolibarr' => [
            'heading' => 'Dolibarr',
            'description' => 'Import members and memberships from Dolibarr.',
            'action_label' => 'Sync Dolibarr',
            'modal_heading' => 'Dolibarr Synchronisation',
            'modal_description' => 'Import members and memberships from Dolibarr.',
        ],
        'expired' => [
            'heading' => 'Expired Members',
            'description' => 'Deactivate expired members in Dolibarr, ISPConfig and Nextcloud.',
            'action_label' => 'Expired Members',
            'modal_heading' => 'Deactivate Expired Members',
            'modal_description' => 'Deactivate expired members in Dolibarr, ISPConfig and Nextcloud.',
            'dry_run_label' => 'Simulation mode (dry-run)',
            'dry_run_helper' => 'Simulates the operation without making any changes.',
        ],
        'ispconfig_mail' => [
            'heading' => 'ISPConfig Mail',
            'description' => 'Link members to their ISPConfig mail accounts (@retzien.fr).',
            'action_label' => 'ISPConfig Mail',
            'modal_heading' => 'ISPConfig Mail Synchronisation',
            'modal_description' => 'Link members to their ISPConfig mail accounts (@retzien.fr).',
        ],
        'ispconfig_web' => [
            'heading' => 'ISPConfig Web',
            'description' => 'Link members to their web hosting accounts.',
            'action_label' => 'ISPConfig Web',
            'modal_heading' => 'ISPConfig Web Synchronisation',
            'modal_description' => 'Link members to their web hosting accounts.',
            'refresh_cache_label' => 'Clear ISPConfig cache',
            'refresh_cache_helper' => 'Clears the cache before synchronisation.',
        ],
        'nextcloud' => [
            'heading' => 'Nextcloud',
            'description' => 'Link members to their Nextcloud accounts.',
            'action_label' => 'Nextcloud',
            'modal_heading' => 'Nextcloud Synchronisation',
            'modal_description' => 'Link members to their Nextcloud accounts.',
            'dry_run_label' => 'Simulation mode (dry-run)',
            'dry_run_helper' => 'Simulates the operation without making any changes.',
        ],
        'services' => [
            'heading' => 'Member Services',
            'description' => 'Synchronise services associated with active members.',
            'action_label' => 'Member Services',
            'modal_heading' => 'Member Services Synchronisation',
            'modal_description' => 'Synchronise services associated with active members.',
        ],
    ],

    'status' => [
        'pending' => 'Waiting in execution queue...',
        'running' => 'Running...',
        'finished_at' => 'Finished at :time',
    ],

    'action' => [
        'submit' => 'Run',
    ],
];
