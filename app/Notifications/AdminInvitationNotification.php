<?php

namespace App\Notifications;

use App\Models\NotificationTemplate;
use Filament\Facades\Filament;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected string $token) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $template = NotificationTemplate::findByIdentifier('admin_invitation');
        $url = Filament::getPanel('admin')->getResetPasswordUrl($this->token, $notifiable);

        $vars = [
            'name' => $notifiable->name,
            'url' => $url,
            'app_name' => config('app.name'),
            'expire_minutes' => config('auth.passwords.users.expire'),
        ];

        return (new MailMessage)
            ->subject($template->renderSubject($vars))
            ->view('notifications.mail-template', [
                'body' => $template->renderBody($vars),
            ]);
    }
}
