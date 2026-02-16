<?php

namespace App\Notifications;

use App\Models\NotificationTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredPhase1 extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly NotificationTemplate $template) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $lastMembership = $notifiable->memberships()->latest()->first();

        $vars = [
            'member_name' => $notifiable->full_name,
            'expiry_date' => $lastMembership?->end_date ?? '',
        ];

        return (new MailMessage)
            ->subject($this->template->renderSubject($vars))
            ->view('notifications.mail-template', [
                'body' => $this->template->renderBody($vars),
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
