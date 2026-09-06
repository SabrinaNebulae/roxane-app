<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Service;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(fn (?Service $record) => $record?->name ?? Service::getAttributeLabel('name'))
                    ->schema([
                        TextInput::make('name')
                            ->label(Service::getAttributeLabel('name'))
                            ->required(),
                        TextInput::make('identifier')
                            ->label(Service::getAttributeLabel('identifier'))
                            ->required(),
                        TextInput::make('description')
                            ->label(Service::getAttributeLabel('description'))
                            ->default(null),
                        TextInput::make('url')
                            ->label(Service::getAttributeLabel('url'))
                            ->url()
                            ->required(),
                        TextInput::make('icon')
                            ->label(Service::getAttributeLabel('icon'))
                            ->default(null),
                    ]),
            ]);
    }
}
