<?php

namespace Database\Seeders;

use App\Models\MemberGroup;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $websiteGroup = MemberGroup::where('identifier', 'website')->first();
        $package = Package::where('identifier', 'one-year')->first();

        $user = User::updateOrCreate(
            ['email' => 'jane@doe.com'],
            [
                'name' => 'JaneDoe',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
            ]
        );

        $member = $user->members()->updateOrCreate(
            ['user_id' => $user->id],
            [
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
            ]
        );

        $member->memberships()->updateOrCreate(
            ['member_id' => $member->id],
            [
                'admin_id' => User::where('email', 'contact@nebulae-design.com')->value('id'),
                'package_id' => $package->id,
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'status' => 'active',
                'amount' => 12.00,
                'payment_status' => 'paid',
            ]
        );
    }
}
