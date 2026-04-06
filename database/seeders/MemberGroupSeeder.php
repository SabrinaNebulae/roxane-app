<?php

namespace Database\Seeders;

use App\Models\MemberGroup;
use Illuminate\Database\Seeder;

class MemberGroupSeeder extends Seeder
{
    public function run(): void
    {
        MemberGroup::updateOrCreate(
            ['identifier' => 'admin-interface'],
            [
                'name' => 'Admin Interface',
                'description' => 'Groupe d\'utilisateurs créés par les administrateurs du site.',
            ]
        );

        MemberGroup::updateOrCreate(
            ['identifier' => 'website'],
            [
                'name' => 'Site Web',
                'description' => 'Groupe d\'utilisateurs provenant du site web.',
            ]
        );
    }
}
