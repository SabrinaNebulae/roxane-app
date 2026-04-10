<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Mail\Events\MessageSending;
use Symfony\Component\Mime\Address;

class PreprodMailInterceptor
{
    public function handle(MessageSending $event): void
    {
        if (! config('preprod.enabled')) {
            return;
        }

        $message = $event->message;
        $adminEmail = config('app.admin_email');

        $originalRecipients = array_map(
            fn (Address $address) => $address->getAddress(),
            $message->getTo()
        );

        $isAdminMail = collect($originalRecipients)->contains(
            fn (string $email) => $email === $adminEmail
                || User::where('email', $email)->exists()
        );

        $configKey = $isAdminMail ? 'preprod.admin_mails' : 'preprod.test_mails';

        $emails = collect(explode(',', config($configKey, '')))
            ->map(fn (string $email) => trim($email))
            ->filter()
            ->values()
            ->all();

        if (empty($emails)) {
            return;
        }

        // Clear all recipient headers before redirecting
        foreach (['To', 'Cc', 'Bcc'] as $header) {
            while ($message->getHeaders()->has($header)) {
                $message->getHeaders()->remove($header);
            }
        }

        $message->to(...$emails);

        $subject = $message->getSubject() ?? '';
        if (! str_starts_with($subject, '[PREPROD]')) {
            $message->subject('[PREPROD] '.$subject);
        }
    }
}
