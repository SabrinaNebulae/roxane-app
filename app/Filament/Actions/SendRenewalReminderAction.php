<?php

namespace App\Filament\Actions;

use App\Models\Membership;
use App\Services\MemberRenewalService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class SendRenewalReminderAction extends Action
{
    public static function make(?string $name = 'send_renewal_reminder'): static
    {
        return parent::make($name)
            ->label('Envoyer une relance')
            ->icon('heroicon-o-envelope')
            ->color('primary')
            ->disabled(function () {
                $today = now();

                return ! ($today->month === 12 || ($today->month === 1 && $today->day <= 31));
            })
            ->requiresConfirmation()
            ->modalHeading('Envoyer une relance de renouvellement')
            ->modalDescription(fn (Membership $record) => "Envoyer une relance à {$record->member->full_name} ({$record->member->email}) ?")
            ->form([
                Select::make('reminder_type')
                    ->label('Type de relance')
                    ->options([
                        'reminder_1' => '1ère relance (début décembre)',
                        'reminder_2' => '2ème relance (mi-décembre)',
                        'reminder_3' => '3ème relance (début janvier)',
                    ])
                    ->required()
                    ->default('reminder_1'),

                TextInput::make('year')
                    ->label('Année de renouvellement')
                    ->default(now()->addYear()->year)
                    ->numeric()
                    ->required(),
            ])
            ->action(function (Membership $record, array $data) {
                $service = app(MemberRenewalService::class);
                $member = $record->member;
                $year = (int) $data['year'];

                match ($data['reminder_type']) {
                    'reminder_1' => $service->sendReminder1($member, $year),
                    'reminder_2' => $service->sendReminder2($member, $year),
                    'reminder_3' => $service->sendReminder3($member, $year),
                };

                Notification::make()
                    ->title('Relance envoyée')
                    ->success()
                    ->send();
            });
    }
}
