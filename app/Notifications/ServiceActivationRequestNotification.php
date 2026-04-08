<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\NotificationTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceActivationRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Member $member,
        public readonly string $serviceIdentifier,
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
        $template = NotificationTemplate::findByIdentifier('service_activation_request');

        $vars = [
            'member_name' => $this->member->full_name,
            'member_email' => $this->member->email ?? '',
            'service_identifier' => $this->serviceIdentifier,
            'app_name' => config('app.name'),
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
