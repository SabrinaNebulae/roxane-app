<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberRenewalReminder;
use App\Notifications\MemberAccountDeactivatedNotification;
use App\Notifications\MemberRenewalReminder2Notification;
use App\Notifications\MemberRenewalReminder3Notification;
use App\Notifications\MemberRenewalReminderNotification;
use App\Services\Dolibarr\DolibarrService;

class MemberRenewalService
{
    public function __construct(
        protected DolibarrService $dolibarr,
        protected MemberService $memberService
    ) {}

    public function sendReminder1(Member $member, int $year): bool
    {
        $reminder = MemberRenewalReminder::firstOrCreate(
            ['member_id' => $member->id, 'renewal_year' => $year],
        );

        if ($reminder->reminder_1_sent) {
            return false;
        }

        if ($this->hasActiveMembershipForYear($member, $year)) {
            return false;
        }

        if (! $this->shouldSendRenewalForYear($member, $year)) {
            return false;
        }

        $member->notify(new MemberRenewalReminderNotification($member));

        $reminder->markAsReminder1Sent();

        return true;
    }

    public function sendReminder2(Member $member, int $year): bool
    {
        $reminder = MemberRenewalReminder::firstOrCreate(
            ['member_id' => $member->id, 'renewal_year' => $year],
        );

        if ($reminder->reminder_2_sent) {
            return false;
        }

        if ($this->hasActiveMembershipForYear($member, $year)) {
            return false;
        }

        if (! $this->shouldSendRenewalForYear($member, $year)) {
            return false;
        }

        $member->notify(new MemberRenewalReminder2Notification($member));

        $reminder->markAsReminder2Sent();

        return true;
    }

    public function sendReminder3(Member $member, int $year): bool
    {
        $reminder = MemberRenewalReminder::firstOrCreate(
            ['member_id' => $member->id, 'renewal_year' => $year],
        );

        if ($reminder->reminder_3_sent) {
            return false;
        }

        if ($this->hasActiveMembershipForYear($member, $year)) {
            return false;
        }

        if (! $this->shouldSendRenewalForYear($member, $year)) {
            return false;
        }

        $member->notify(new MemberRenewalReminder3Notification($member));

        $reminder->markAsReminder3Sent();

        return true;
    }

    public function deactivateMember(Member $member, int $year): bool
    {
        $reminder = MemberRenewalReminder::firstOrCreate(
            ['member_id' => $member->id, 'renewal_year' => $year],
        );

        if ($reminder->deactivation_sent) {
            return false;
        }

        if ($this->hasActiveMembershipForYear($member, $year)) {
            return false;
        }

        $this->memberService->deactivateMember($member);

        $member->notify(new MemberAccountDeactivatedNotification($member));

        $reminder->markAsDeactivated();

        return true;
    }

    protected function hasActiveMembershipForYear(Member $member, int $year): bool
    {
        $yearStart = "{$year}-01-01";
        $yearEnd = "{$year}-12-31";

        return $member->memberships()
            ->where('status', 'active')
            ->where(function ($query) use ($yearStart, $yearEnd) {
                $query->where(function ($q) use ($yearStart, $yearEnd) {
                    $q->where('start_date', '<=', $yearEnd)
                        ->where(function ($q2) use ($yearStart) {
                            $q2->whereNull('end_date')
                                ->orWhere('end_date', '>=', $yearStart);
                        });
                });
            })
            ->exists();
    }

    protected function shouldSendRenewalForYear(Member $member, int $year): bool
    {
        $currentMembership = $member->memberships()
            ->where('status', 'active')
            ->orderBy('end_date', 'desc')
            ->first();

        if (! $currentMembership || ! $currentMembership->end_date) {
            return false;
        }

        $expirationYear = (int) date('Y', strtotime($currentMembership->end_date));

        return $expirationYear === ($year - 1);
    }
}
