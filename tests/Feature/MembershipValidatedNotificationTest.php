<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Membership;
use App\Models\NotificationTemplate;
use App\Models\Package;
use App\Notifications\MembershipValidatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MembershipValidatedNotificationTest extends TestCase
{
    use RefreshDatabase;

    private function createPendingMembership(): Membership
    {
        $package = Package::create([
            'identifier' => 'one-year',
            'name' => 'Adhésion annuelle',
            'price' => 12.00,
            'is_active' => true,
        ]);

        $member = Member::factory()->create([
            'status' => 'pending',
            'nature' => 'physical',
        ]);

        return Membership::create([
            'member_id' => $member->id,
            'package_id' => $package->id,
            'status' => 'pending',
            'amount' => 12.00,
            'payment_status' => 'unpaid',
        ]);
    }

    public function test_member_receives_notification_when_membership_is_validated(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->create(['identifier' => 'membership_validated', 'is_active' => true]);

        $membership = $this->createPendingMembership();

        $membership->update(['status' => 'active']);
        $membership->member->notify(new MembershipValidatedNotification($membership->fresh(['member', 'package'])));

        Notification::assertSentTo($membership->member, MembershipValidatedNotification::class);
    }

    public function test_validated_notification_contains_correct_membership(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->create(['identifier' => 'membership_validated', 'is_active' => true]);

        $membership = $this->createPendingMembership();

        $membership->update(['status' => 'active']);
        $freshMembership = $membership->fresh(['member', 'package']);
        $freshMembership->member->notify(new MembershipValidatedNotification($freshMembership));

        Notification::assertSentTo(
            $membership->member,
            MembershipValidatedNotification::class,
            function (MembershipValidatedNotification $notification) use ($membership): bool {
                return $notification->membership->id === $membership->id;
            }
        );
    }

    public function test_notification_is_not_sent_when_status_is_not_active(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->create(['identifier' => 'membership_validated', 'is_active' => true]);

        $membership = $this->createPendingMembership();

        Notification::assertNotSentTo($membership->member, MembershipValidatedNotification::class);
    }
}
