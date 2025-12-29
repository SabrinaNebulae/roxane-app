<?php

namespace App\Services;

use App\Events\MemberRegistered;
use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\Package;

class MemberService
{
    public function registerNewMember(array $data): Member
    {
        // Check if the member already exists
        $member = Member::where('email', $data['email'])->first();

        if (!$member) {
            // Create a new member
            $member = new Member();
            $member->status = 'pending';
            $member->nature = 'physical';
            $member->group_id = MemberGroup::where('identifier', 'website')->first()->id ?? null;
            $member->lastname = $data['lastname'];
            $member->firstname = $data['firstname'];
            $member->email = $data['email'];
            $member->company = $data['company'] ?? null;
            $member->address = $data['address'];
            $member->zipcode = $data['zipcode'];
            $member->city = $data['city'];
            $member->country = 'FR';
            $member->phone1 = $data['phone1'];
            $member->save();
        }

        $package = Package::where('identifier', $data['package'])
            ->where('is_active', true)
            ->firstOrFail();

        // Create a new membership
        $member->memberships()->create([
            'status' => 'pending',
            'package_id' => $package->id ?? null,
            'amount' => $data['amount'],
            'payment_status' => 'unpaid',

        ]);

        // Notify Admin
        $admin = Member::where('role', 'admin')->first();
        event(new MemberRegistered($admin));


        return $member;
    }
}
