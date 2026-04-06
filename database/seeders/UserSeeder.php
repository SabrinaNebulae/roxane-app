<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'contact@nebulae-design.com'],
            [
                'name' => 'SuperAdmin',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ]
        );
    }
}
