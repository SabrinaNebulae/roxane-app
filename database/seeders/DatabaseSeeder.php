<?php

namespace Database\Seeders;

use App\Models\MemberGroup;
use App\Models\Package;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate([
            'name' => 'SuperAdmin',
        ],
            [
                'email' => 'contact@nebulae-design.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ]);

        // Member groups
        $adminGroup = MemberGroup::updateOrCreate([
            'name' => 'Admin Interface',
        ], [
            'identifier' => 'admin-interface',
            'description' => 'Groupe d\'utilisateurs créés par les administrateurs du site.',
        ]);

        $websiteGroup = MemberGroup::updateOrCreate([
            'name' => 'Site Web',
        ],
            [
                'identifier' => 'website',
                'description' => 'Groupe d\'utilisateurs provenant du site web.',
            ]);

        // Subscription packages
        $packages = [
            [
                'identifier' => 'custom',
                'name' => 'Sur-mesure',
                'description' => 'Calcul du nombre de mois restant dans l\'année',
                'price' => '1.00',
            ],
            [
                'identifier' => 'one-year',
                'name' => 'Un an',
                'description' => '12 mois à compter de la date de validation de l\'adhésion du membre',
                'price' => '12.00',
            ],
            [
                'identifier' => 'two-years',
                'name' => 'Deux ans',
                'description' => '24 mois à compter de la date de validation de l\'adhésion du membre',
                'price' => '24.00',
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate([
                'identifier' => $package['identifier'],
            ], [
                'name' => $package['name'],
                'description' => $package['description'],
                'price' => $package['price'],
                'is_active' => true,
            ]);
        }

        // Services
        $services = [
            [
                'identifier' => 'mail',
                'name' => 'Mail RoundCube',
                'description' => 'Service de messagerie',
                'url' => '#',
                'icon' => 'mail',
            ],
            [
                'identifier' => 'file2link',
                'name' => 'File2Link',
                'description' => 'Service de partage de fichiers',
                'url' => '#',
                'icon' => 'document-add',
            ],
            [
                'identifier' => 'nextcloud',
                'name' => 'Nextcloud',
                'description' => 'Service de stockage de fichiers',
                'url' => '#',
                'icon' => 'cloud-upload',
            ],
            [
                'identifier' => 'sympa',
                'name' => 'Sympa',
                'description' => 'Service de gestion de listes de diffusion',
                'url' => '#',
                'icon' => 'clipboard-list',
            ],
            [
                'identifier' => 'webhosting',
                'name' => 'Hébergement web',
                'description' => 'Service d\'hébergement web',
                'url' => '#',
                'icon' => 'database',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate([
                'identifier' => $service['identifier'],
            ], [
                'name' => $service['name'],
                'description' => $service['description'],
                'url' => $service['url'],
                'icon' => $service['icon'],
            ]);
        }

        // Notification templates
        $this->call(NotificationTemplateSeeder::class);

        // JaneDoe
        $userTest = User::updateOrCreate([
            'name' => 'JaneDoe',
        ],
            [
                'email' => 'jane@doe.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
            ]);

        $memberTest = $userTest->members()->updateOrCreate([
            'user_id' => $userTest->id,
        ], [
            'status' => 'valid',
            'nature' => 'physical',
            'group_id' => $websiteGroup->id,
            'lastname' => 'Doe',
            'firstname' => 'Jane',
            'email' => 'jane@doe.com',
            'company' => 'Nebulae Design',
            'date_of_birth' => '1990-01-06',
            'address' => '123 Rue du Test',
            'zipcode' => '49000',
            'city' => 'Saumur',
            'country' => 'FR',
            'phone1' => '0123456789',
            'phone2' => '0123456789',
            'public_membership' => false,
        ]);

        $membershipTest = $memberTest->memberships()->updateOrCreate([
            'member_id' => $memberTest->id,
        ], [
            'admin_id' => '1',
            'package_id' => Package::where('identifier', 'one-year')->first()->id,
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'status' => 'active',
            'amount' => 12.00,
            'payment_status' => 'paid',
        ]);

    }
}
