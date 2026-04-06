<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MemberGroupSeeder::class,
            PackageSeeder::class,
            ServiceSeeder::class,
            UserSeeder::class,
            NotificationTemplateSeeder::class,
        ]);

        if (! app()->isProduction()) {
            $this->call(DemoSeeder::class);
        }
    }
}
