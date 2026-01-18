<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Enums\IspconfigType;
use App\Models\Member;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Actions;


class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Section::make('Informations personnelles')
                                    ->schema([
                                        TextInput::make('lastname')
                                            ->label(Member::getAttributeLabel('lastname'))
                                            ->required(),

                                        TextInput::make('firstname')
                                            ->label(Member::getAttributeLabel('firstname'))
                                            ->required(),

                                        DatePicker::make('date_of_birth')
                                            ->label(Member::getAttributeLabel('date_of_birth')),

                                        TextInput::make('company')
                                            ->label(Member::getAttributeLabel('company')),
                                    ])
                                    ->columns(2),

                                Section::make('Informations administratives')
                                    ->schema([
                                        TextInput::make('keycloak_id')
                                            ->label(Member::getAttributeLabel('keycloak_id')),

                                        Select::make('nature')
                                            ->label(Member::getAttributeLabel('nature'))
                                            ->options([
                                                'physical' => Member::getAttributeLabel('physical'),
                                                'legal' => Member::getAttributeLabel('legal'),
                                            ])
                                            ->default('physical')
                                            ->required(),

                                        Select::make('group_id')
                                            ->label(Member::getAttributeLabel('group_id'))
                                            ->relationship('group', 'name')
                                            ->default(null),
                                    ])
                                    ->columns(2),

                                Section::make('Coordonnées')
                                    ->schema([
                                        TextInput::make('email')
                                            ->label(Member::getAttributeLabel('email'))
                                            ->email()
                                            ->required(),

                                        TextInput::make('phone1')
                                            ->label(Member::getAttributeLabel('phone1'))
                                            ->tel(),

                                        TextInput::make('phone2')
                                            ->label(Member::getAttributeLabel('phone2'))
                                            ->tel(),

                                        TextInput::make('address')
                                            ->label(Member::getAttributeLabel('address')),

                                        TextInput::make('zipcode')
                                            ->label(Member::getAttributeLabel('zipcode')),

                                        TextInput::make('city')
                                            ->label(Member::getAttributeLabel('city')),

                                        TextInput::make('country')
                                            ->label(Member::getAttributeLabel('country')),
                                    ])
                                    ->columns(2),
                                // Mail Retzien
                                Section::make('Messagerie ISPConfig Retzien')
                                    ->schema([
                                        TextEntry::make('isp_mail_email')
                                            ->label('Adresse email')
                                            ->state(fn (?Member $record) =>
                                                $record?->ispconfigMail()?->email ?? '—'
                                            ),

                                        TextEntry::make('isp_mail_user_id')
                                            ->label('ID utilisateur ISPConfig (mailuser_id)')
                                            ->state(fn (?Member $record) =>
                                                $record?->ispconfigMail()?->ispconfig_service_user_id ?? '—'
                                            ),

                                        TextEntry::make('isp_mail_quota')
                                            ->label('Quota')
                                            ->state(function (?Member $record) {
                                                $quota = $record?->ispconfigMail()?->data['mailuser']['quota'] ?? null;

                                                return $quota
                                                    ? "{$quota} Mo"
                                                    : 'Non défini';
                                            }),

                                        TextEntry::make('isp_mail_domain')
                                            ->label('Domaine')
                                            ->state(fn (?Member $record) =>
                                                $record?->ispconfigMail()?->data['mailuser']['domain'] ?? 'retzien.fr'
                                            ),
                                    ])
                                    ->columns(2)
                                    ->visible(fn (?Member $record) =>
                                        $record?->ispconfigMail() !== null
                                    ),

                                // Hébergement

                                Section::make('Hébergements Web')
                                    ->schema([
                                        Placeholder::make('ispconfigs_web_display')
                                            ->label('')
                                            ->content(fn (?Member $record) => view('filament.components.ispconfig-web-list', [
                                                'ispconfigs' => $record?->ispconfigs()
                                                        ->where('type', IspconfigType::WEB)
                                                        ->get() ?? collect()
                                            ]))
                                    ])
                                    ->visible(fn (?Member $record) =>
                                    $record?->ispconfigs()->where('type', IspconfigType::WEB)->exists()
                                    )
                                // Fin Hébergement
                            ])
                            ->columnSpan(3),
                        Grid::make(1)
                            ->schema([
                                Section::make('Statut')
                                    ->schema([
                                        Select::make('status')
                                            ->label(Member::getAttributeLabel('status'))
                                            ->options([
                                                'draft' => Member::getAttributeLabel('draft'),
                                                'valid' => Member::getAttributeLabel('valid'),
                                                'pending' => Member::getAttributeLabel('pending'),
                                                'cancelled' => Member::getAttributeLabel('cancelled'),
                                                'excluded' => Member::getAttributeLabel('excluded'),
                                            ])
                                            ->default('draft')
                                            ->required(),

                                        Toggle::make('public_membership')
                                            ->label(Member::getAttributeLabel('public_membership'))
                                            ->required(),
                                    ])
                                    ->columns(1)
                                    ->extraAttributes(['class' => 'sticky top-4 h-fit']),
                                Section::make('Actions')
                                    ->schema([
                                        Action::make('send-payment-mail')
                                            ->icon('heroicon-o-envelope')
                                            ->label('Envoyer le mail de paiement')
                                        ->action(function(){
                                            $this->data['status'] = 'draft';
                                            $this->create();
                                        }),
                                        Action::make('send-renewal-mail')
                                            ->icon('heroicon-o-envelope')
                                            ->label('Envoyer un mail de relance')
                                            ->action(function(){
                                                $this->data['status'] = 'draft';
                                                $this->create();
                                            })
                                    ])
                                    ->columns(1)
                                    ->extraAttributes(['class' => 'sticky top-4 h-fit'])
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }
}
