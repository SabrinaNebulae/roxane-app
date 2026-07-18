<?php

namespace App\Notifications;

use App\Models\Membership;
use App\Models\NotificationTemplate;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipValidatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Membership $membership) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $template = NotificationTemplate::findByIdentifier('membership_validated');

        $vars = [
            'member_name' => $this->membership->member->full_name,
            'package_name' => $this->membership->package->name,
            'start_date' => $this->membership->start_date ? Carbon::parse($this->membership->start_date)->format('d/m/Y') : '',
            'end_date' => $this->membership->end_date ? Carbon::parse($this->membership->end_date)->format('d/m/Y') : '',
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
