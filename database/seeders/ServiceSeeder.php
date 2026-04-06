<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'identifier' => 'mail',
                'name' => 'Mail RoundCube',
                'description' => 'Service de messagerie',
                'url' => '#',
                'icon' => 'envelope',
            ],
            [
                'identifier' => 'file2link',
                'name' => 'File2Link',
                'description' => 'Service de partage de fichiers',
                'url' => '#',
                'icon' => 'share',
            ],
            [
                'identifier' => 'nextcloud',
                'name' => 'Nextcloud',
                'description' => 'Service de stockage de fichiers',
                'url' => '#',
                'icon' => 'cloud',
            ],
            [
                'identifier' => 'sympa',
                'name' => 'Sympa',
                'description' => 'Service de gestion de listes de diffusion',
                'url' => '#',
                'icon' => 'megaphone',
            ],
            [
                'identifier' => 'listmonk',
                'name' => 'ListMonk',
                'description' => 'Service de newsletter et listes de diffusion',
                'url' => '#',
                'icon' => 'newspaper',
            ],
            [
                'identifier' => 'webhosting',
                'name' => 'Hébergement web',
                'description' => 'Service d\'hébergement web',
                'url' => '#',
                'icon' => 'globe-alt',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['identifier' => $service['identifier']],
                [
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'url' => $service['url'],
                    'icon' => $service['icon'],
                ]
            );
        }
    }
}
