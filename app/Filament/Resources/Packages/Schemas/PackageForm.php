<?php

namespace App\Filament\Resources\Packages\Schemas;

use App\Models\Package;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(fn (?Package $record) => $record?->name ?? Package::getAttributeLabel('name'))
                    ->afterHeader([
                        Toggle::make('is_active')
                            ->label(Package::getAttributeLabel('is_active'))
                            ->default(false),
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label(Package::getAttributeLabel('name'))
                            ->required()
                            ->default(null),
                        TextInput::make('identifier')
                            ->label(Package::getAttributeLabel('identifier'))
                            ->required()
                            ->disabledOn('edit')
                            ->default(null),
                        Textarea::make('description')
                            ->label(Package::getAttributeLabel('description'))
                            ->default(null),
                    ]),

            ]);
    }
}
