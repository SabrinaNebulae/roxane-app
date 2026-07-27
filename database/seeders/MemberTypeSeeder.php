<?php

namespace Database\Seeders;

use App\Models\MemberType;
use Illuminate\Database\Seeder;

class MemberTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'identifier' => 'individual',
                'name' => 'Particulier',
                'description' => 'Personne physique',
            ],
            [
                'identifier' => 'company',
                'name' => 'Entreprise',
                'description' => 'Personne morale (société, auto-entrepreneur, etc.)',
            ],
            [
                'identifier' => 'association',
                'name' => 'Association',
                'description' => 'Association loi 1901',
            ],
        ];

        foreach ($types as $type) {
            MemberType::updateOrCreate(
                ['identifier' => $type['identifier']],
                [
                    'name' => $type['name'],
                    'description' => $type['description'],
                ]
            );
        }
    }
}