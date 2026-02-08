<?php

namespace App\Jobs;

use App\Models\Member;
use App\Notifications\SubscriptionExpiredPhase1;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSubscriptionExpiredPhase1Notifications implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Member::isExpired()
            ->chunk(100, function ($members) {
                foreach ($members as $member) {
                    $member->notify(new SubscriptionExpiredPhase1());
                }
            });
    }
}
