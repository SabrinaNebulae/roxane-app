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
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label(User::getAttributeLabel('email_verified_at')),
                TextInput::make('password')
                    ->label(User::getAttributeLabel('password'))
                    ->password()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->hint(fn (string $operation) => $operation === 'create'
                        ? __('users.hints.password_create')
                        : __('users.hints.password_edit'))
                    ->hintIcon('heroicon-m-information-circle'),
                Select::make('role')
                    ->label(User::getAttributeLabel('role'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }
}
