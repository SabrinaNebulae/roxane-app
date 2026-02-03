<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(User::getAttributeLabel('name'))
                    ->required(),
                TextInput::make('email')
                    ->label(User::getAttributeLabel('email'))
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label(User::getAttributeLabel('email_verified_at')),
                TextInput::make('password')
                    ->label(User::getAttributeLabel('password'))
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Select::make('role')
                    ->label(User::getAttributeLabel('role'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
            ]);
    }
}
