<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\NotificationTemplate;
use App\Models\Package;
use App\Notifications\MemberNewRequestAdminNotification;
use App\Notifications\MemberNewRequestMemberNotification;
use App\Services\MemberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MemberNewRequestMemberNotificationTest extends TestCase
{
    use RefreshDatabase;

    private function createPackage(): Package
    {
        return Package::create([
            'identifier' => 'one-year',
            'name' => 'Adhésion annuelle',
            'price' => 12.00,
            'is_active' => true,
        ]);
    }

    private function memberData(Package $package): array
    {
        return [
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'phone1' => '0600000000',
            'address' => '1 rue de la Paix',
            'zipcode' => '44000',
            'city' => 'Nantes',
            'package' => $package->identifier,
            'amount' => 12.00,
        ];
    }

    public function test_member_receives_confirmation_notification_on_registration(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->create(['identifier' => 'member_new_request_admin', 'is_active' => true]);
        NotificationTemplate::factory()->create(['identifier' => 'member_new_request_member', 'is_active' => true]);

        $package = $this->createPackage();

        (new MemberService)->registerNewMember($this->memberData($package));

        $member = Member::where('email', 'jean.dupont@example.com')->firstOrFail();

        Notification::assertSentTo($member, MemberNewRequestMemberNotification::class);
    }

    public function test_confirmation_notification_contains_correct_member_and_package(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->create(['identifier' => 'member_new_request_admin', 'is_active' => true]);
        NotificationTemplate::factory()->create(['identifier' => 'member_new_request_member', 'is_active' => true]);

        $package = $this->createPackage();

        (new MemberService)->registerNewMember($this->memberData($package));

        $member = Member::where('email', 'jean.dupont@example.com')->firstOrFail();

        Notification::assertSentTo(
            $member,
            MemberNewRequestMemberNotification::class,
            function (MemberNewRequestMemberNotification $notification) use ($member, $package): bool {
                return $notification->member->id === $member->id
                    && $notification->package->id === $package->id;
            }
        );
    }

    public function test_admin_notification_is_also_sent_on_registration(): void
    {
        Notification::fake();

        NotificationTemplate::factory()->create(['identifier' => 'member_new_request_admin', 'is_active' => true]);
        NotificationTemplate::factory()->create(['identifier' => 'member_new_request_member', 'is_active' => true]);

        $package = $this->createPackage();

        (new MemberService)->registerNewMember($this->memberData($package));

        Notification::assertSentOnDemand(MemberNewRequestAdminNotification::class);
    }
}
