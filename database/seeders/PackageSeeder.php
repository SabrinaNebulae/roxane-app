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
                'name' => 'Année en cours',
                'description' => 'Mois restants dans l\'année civile en cours (1€/mois)',
                'price' => '1.00',
            ],
            [
                'identifier' => 'one-year',
                'name' => 'Année en cours + 1 an',
                'description' => 'Jusqu\'à la fin de l\'année civile suivante (1€/mois)',
                'price' => '12.00',
            ],
            [
                'identifier' => 'two-years',
                'name' => 'Année en cours + 2 ans',
                'description' => 'Jusqu\'à la fin de la 2e année civile suivante (1€/mois)',
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
