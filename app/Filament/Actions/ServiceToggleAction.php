<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Bus;
use App\Models\Member;

class ServiceToggleAction extends Action
{
    protected string $serviceIdentifier;

    public static function forService(string $serviceIdentifier): static
    {
        return static::make('toggle_' . $serviceIdentifier)
            ->configureForService($serviceIdentifier);
    }

    protected function configureForService(string $serviceIdentifier): static
    {
        $this->serviceIdentifier = $serviceIdentifier;

        return $this
            ->label('Service actif')
            ->icon(fn (Member $record) =>
            $record->hasService($serviceIdentifier)
                ? 'heroicon-o-check-circle'
                : 'heroicon-o-x-circle'
            )
            ->color(fn (Member $record) =>
            $record->hasService($serviceIdentifier)
                ? 'success'
                : 'gray'
            )
            ->requiresConfirmation()
            ->modalHeading(fn (Member $record) =>
            $record->hasService($serviceIdentifier)
                ? 'Désactiver le service'
                : 'Activer le service'
            )
            ->modalDescription(fn (Member $record) =>
            $record->hasService($serviceIdentifier)
                ? 'Êtes-vous sûr·e de vouloir désactiver ce service pour ce membre ?'
                : 'Êtes-vous sûr·e de vouloir activer ce service pour ce membre ?'
            )
            ->modalSubmitActionLabel(fn (Member $record) =>
            $record->hasService($serviceIdentifier)
                ? 'Désactiver'
                : 'Activer'
            )
            ->action(function (Member $record) use ($serviceIdentifier) {

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
}
