<?php

namespace App\Notifications;

use App\Filament\Resources\Members\MemberResource;
use App\Models\Member;
use App\Models\NotificationTemplate;
use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberNewRequestAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Member $member,
        public readonly Package $package,
        public readonly float $amount,
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
        $template = NotificationTemplate::findByIdentifier('member_new_request_admin');

        $vars = [
            'member_name' => $this->member->full_name,
            'member_email' => $this->member->email ?? '',
            'member_phone' => $this->member->phone1 ?? '',
            'member_address' => implode(', ', array_filter([
                $this->member->address,
                $this->member->zipcode,
                $this->member->city,
            ])),
            'package_name' => $this->package->name,
            'amount' => number_format($this->amount, 2, ',', ' '),
            'member_url' => MemberResource::getUrl('edit', ['record' => $this->member->id]),
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
