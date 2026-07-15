<?php

namespace App\Filament\Resources\Memberships\Pages;

use App\Filament\Resources\Memberships\MembershipResource;
use App\Models\Membership;
use App\Notifications\MembershipValidatedNotification;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class EditMembership extends EditRecord
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('validate')
                ->label(__('memberships.actions.validate'))
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->visible(fn (Membership $record) => $record->status === 'pending')
                ->form([
                    DatePicker::make('start_date')
                        ->label(Membership::getAttributeLabel('start_date'))
                        ->required(),
                    DatePicker::make('end_date')
                        ->label(Membership::getAttributeLabel('end_date'))
                        ->required(),
                ])
                ->fillForm(fn (Membership $record): array => [
                    'start_date' => $record->start_date,
                    'end_date' => $record->end_date,
                ])
                ->action(function (Membership $record, array $data): void {
                    $record->update([
                        'status' => 'active',
                        'start_date' => $data['start_date'],
                        'end_date' => $data['end_date'],
                    ]);
                    $record->member->notify(new MembershipValidatedNotification($record->fresh(['member', 'package'])));
                }),
            DeleteAction::make(),
        ];
    }

    /**
     * @property Membership $record
     */
    public function getTitle(): string|Htmlable
    {
        return Membership::getAttributeLabel('membership').' #'.$this->record->id;
    }
}
