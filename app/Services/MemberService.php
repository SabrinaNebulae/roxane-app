<?php

namespace App\Services;

use App\Events\MemberRegistered;
use App\Models\Member;
use App\Models\MemberGroup;
use App\Models\Package;
use App\Notifications\MemberDeactivatedAdminNotification;
use App\Notifications\MemberDeactivatedMemberNotification;
use App\Notifications\MemberNewRequestAdminNotification;
use Illuminate\Support\Facades\Notification;

class MemberService
{
    /**
     * Register a new member.
     */
    public function registerNewMember(array $data): Member
    {
        // Check if the member already exists
        $member = Member::where('email', $data['email'])->first();

        if (! $member) {
            // Create a new member
            $member = new Member;
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

        Notification::route('mail', config('app.admin_email'))
            ->notify(new MemberNewRequestAdminNotification($member, $package, (float) $data['amount']));

        event(new MemberRegistered($member));

        return $member;
    }

    /**
     * Disable a member and his subscriptions
     */
    public function deactivateMember(Member $member): void
    {
        $member->update(['status' => 'excluded']);
        $membership = $member->memberships()
            ->where('status', 'active')->first();
        $membership->update(['status' => 'inactive']);

        $membership->services()->detach();

        $member->notify(new MemberDeactivatedMemberNotification($member));

        Notification::route('mail', config('app.admin_email'))
            ->notify(new MemberDeactivatedAdminNotification($member));
    }
}
