<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
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
            Package::updateOrCreate(
                ['identifier' => $package['identifier']],
                [
                    'name' => $package['name'],
                    'description' => $package['description'],
                    'price' => $package['price'],
                    'is_active' => true,
                ]
            );
        }
    }
}
