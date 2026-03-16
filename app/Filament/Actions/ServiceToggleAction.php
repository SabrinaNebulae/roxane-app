<?php

namespace App\Filament\Actions;

use App\Models\Membership;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Bus;
use App\Models\Member;

class ServiceToggleAction extends Action
{
    protected string $serviceIdentifier;

    /*
     * Create a new action instance.
     */
    public static function forService(string $serviceIdentifier): static
    {
        return static::make('toggle_' . $serviceIdentifier)
            ->configureForService($serviceIdentifier);
    }

    /**
     * Configure the action for a specific service.
     */
    protected function configureForService(string $serviceIdentifier): static
    {
        $this->serviceIdentifier = $serviceIdentifier;

        return $this
            ->label('Service actif')
            ->icon(fn (Member|Membership $record) =>
            $this->getMember($record)?->hasService($serviceIdentifier)
                ? 'heroicon-o-check-circle'
                : 'heroicon-o-x-circle'
            )
            ->color(fn (Member|Membership $record) =>
            $this->getMember($record)?->hasService($serviceIdentifier)
                ? 'success'
                : 'gray'
            )
            ->requiresConfirmation()
            ->modalHeading(fn (Member|Membership $record) =>
            $this->getMember($record)?->hasService($serviceIdentifier)
                ? 'Désactiver le service'
                : 'Activer le service'
            )
            ->modalDescription(fn (Member|Membership $record) =>
            $this->getMember($record)?->hasService($serviceIdentifier)
                ? 'Êtes-vous sûr·e de vouloir désactiver ce service pour ce membre ?'
                : 'Êtes-vous sûr·e de vouloir activer ce service pour ce membre ?'
            )
            ->modalSubmitActionLabel(fn (Member|Membership $record) =>
            $this->getMember($record)?->hasService($serviceIdentifier)
                ? 'Désactiver'
                : 'Activer'
            )
            ->action(function (Member|Membership $record) use ($serviceIdentifier) {
                $member = $this->getMember($record);

                if (!$member) {
                    return;
                }

                // @todo à discuter
               /* if ($record->hasService($serviceIdentifier)) {
                    Bus::dispatch(
                        new \App\Jobs\DisableServiceJob($record, $serviceIdentifier)
                    );
                } else {
                    Bus::dispatch(
                        new \App\Jobs\EnableServiceJob($record, $serviceIdentifier)
                    );
                }*/
            });
    }

    /**
     * Get the member associated with the given record.
     */
    protected function getMember(Member|Membership $record): ?Member
    {
        return $record instanceof Member ? $record : $record->member;
    }
}
