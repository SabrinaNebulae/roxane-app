<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\NotificationTemplate;
use App\Notifications\SubscriptionExpiredPhase1;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSubscriptionExpiredPhase1Notifications implements ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function handle(): void
    {
        $template = NotificationTemplate::findByIdentifier('subscription_expired_phase1');

        if (! $template) {
            return;
        }

        Member::query()
            ->whereHas('memberships', fn ($query) => $query->where('status', 'expired'))
            ->chunk(100, function ($members) use ($template) {
                foreach ($members as $member) {
                    $member->notify(new SubscriptionExpiredPhase1($template));
                }
            });
    }
}
