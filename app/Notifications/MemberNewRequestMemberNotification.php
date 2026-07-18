<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\NotificationTemplate;
use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberNewRequestMemberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Member $member,
        public readonly Package $package,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $template = NotificationTemplate::findByIdentifier('member_new_request_member');

        $vars = [
            'member_name' => $this->member->full_name,
            'package_name' => $this->package->name,
            'app_name' => config('app.front_name'),
        ];

        return (new MailMessage)
            ->subject($template->renderSubject($vars))
            ->view('notifications.mail-template', [
                'body' => $template->renderBody($vars),
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
