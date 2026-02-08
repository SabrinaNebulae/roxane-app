<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredPhase1 extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        //@todo: créer template générique + espace dans le BO pour alimenter les texte
        return (new MailMessage)
            ->subject('Votre adhésion est expirée')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre adhésion est arrivée à expiration.')
            ->line('Pour continuer à profiter nos services, merci de le renouveler.')
            ->action('Renouveler mon adhésion', url('/devenir-membre'))
            ->line('Merci pour votre confiance.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
