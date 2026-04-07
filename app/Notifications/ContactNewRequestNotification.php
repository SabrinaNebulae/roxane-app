<?php

namespace App\Notifications;

use App\Models\Contact;
use App\Models\NotificationTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNewRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Contact $contact) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $template = NotificationTemplate::findByIdentifier('contact_new_request');

        $vars = [
            'contact_name' => $this->contact->full_name,
            'contact_email' => $this->contact->email ?? '',
            'contact_subject' => $this->contact->subject ?? '',
            'contact_message' => $this->contact->message ?? '',
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
