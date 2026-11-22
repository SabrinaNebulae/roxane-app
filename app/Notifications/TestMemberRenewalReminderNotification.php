<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\NotificationTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestMemberRenewalReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Member $member,
        public readonly string $phase
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
        $templateIdentifier = $this->getTemplateIdentifier();
        $template = NotificationTemplate::findByIdentifier($templateIdentifier);

        if (! $template) {
            throw new \RuntimeException("Template '{$templateIdentifier}' not found");
        }

        $vars = [
            'member_name' => $this->member->full_name,
            'app_name' => config('app.front_name'),
        ];

        $subject = '[TEST] '.$template->renderSubject($vars);

        return (new MailMessage)
            ->subject($subject)
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

    protected function getTemplateIdentifier(): string
    {
        return match ($this->phase) {
            'reminder_1' => 'member_renewal_reminder',
            'reminder_2' => 'member_renewal_reminder_2',
            'reminder_3' => 'member_renewal_reminder_3',
            'deactivate' => 'member_account_deactivated',
            default => throw new \InvalidArgumentException("Unknown phase: {$this->phase}"),
        };
    }
}
