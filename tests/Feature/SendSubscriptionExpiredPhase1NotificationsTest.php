<?php

namespace Tests\Feature;

use App\Jobs\SendSubscriptionExpiredPhase1Notifications;
use App\Models\Member;
use App\Models\Membership;
use App\Models\NotificationTemplate;
use App\Models\Package;
use App\Notifications\SubscriptionExpiredPhase1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendSubscriptionExpiredPhase1NotificationsTest extends TestCase
{
    use RefreshDatabase;

    private function createMemberWithExpiredMembership(): Member
    {
        $package = Package::create([
            'identifier' => 'test-package',
            'name' => 'Test Package',
            'is_active' => true,
        ]);

        $member = Member::create([
            'email' => fake()->unique()->safeEmail(),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'status' => 'valid',
            'nature' => 'physical',
        ]);

        Membership::create([
            'member_id' => $member->id,
            'package_id' => $package->id,
            'status' => 'expired',
            'end_date' => '2025-12-31',
            'amount' => 12.00,
            'payment_status' => 'paid',
        ]);

        return $member;
    }

    public function test_job_sends_notifications_to_expired_members(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->create([
            'identifier' => 'subscription_expired_phase1',
            'is_active' => true,
        ]);

        $expiredMember = $this->createMemberWithExpiredMembership();

        (new SendSubscriptionExpiredPhase1Notifications)->handle();

        Notification::assertSentTo($expiredMember, SubscriptionExpiredPhase1::class);
    }

    public function test_job_does_nothing_when_template_is_inactive(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->inactive()->create([
            'identifier' => 'subscription_expired_phase1',
        ]);

        $this->createMemberWithExpiredMembership();

        (new SendSubscriptionExpiredPhase1Notifications)->handle();

        Notification::assertNothingSent();
    }

    public function test_job_does_nothing_when_template_does_not_exist(): void
    {
        Notification::fake();

        $this->createMemberWithExpiredMembership();

        (new SendSubscriptionExpiredPhase1Notifications)->handle();

        Notification::assertNothingSent();
    }
}
