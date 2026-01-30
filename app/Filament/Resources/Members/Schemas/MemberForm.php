<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Enums\IspconfigType;
use App\Models\Member;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        /*
                         |--------------------------------------------------------------------------
                         | Colonne principale
                         |--------------------------------------------------------------------------
                         */
                        Grid::make(1)
                            ->schema([
                                Tabs::make('MemberTabs')
                                    ->tabs([
                                        /*
                                         |--------------------------------------------------------------------------
                                         | TAB : Informations générales
                                         |--------------------------------------------------------------------------
                                         */
                                        Tabs\Tab::make('Informations générales')
                                            ->schema([
                                                Section::make('Informations personnelles')
                                                    ->collapsible()
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
                                                    ->collapsible()
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
                                                    ->collapsible()
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
                                            ]),

                                        /*
                                         |--------------------------------------------------------------------------
                                         | TAB : Services/Modules
                                         |--------------------------------------------------------------------------
                                         */
                                        Tabs\Tab::make('Modules')
                                            ->schema([
                                                /*
                                                 | Messageries ISPConfig (lecture seule)
                                                 */
                                                Section::make('Messagerie ISPConfig')
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('ispconfig_mails')
                                                            ->label('')
                                                            ->state(fn(?Member $record) => $record?->ispconfigs()
                                                                ->where('type', IspconfigType::MAIL)
                                                                ->get()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('email')
                                                                    ->label('Adresse email'),

                                                                TextEntry::make('ispconfig_service_user_id')
                                                                    ->label('ID ISPConfig'),

                                                                TextEntry::make('data.mailuser.quota')
                                                                    ->label('Quota')
                                                                    ->formatStateUsing(fn($state) => $state ? "{$state} Mo" : 'Non défini'
                                                                    ),

                                                                TextEntry::make('data.mailuser.domain')
                                                                    ->label('Domaine')
                                                                    ->default('retzien.fr'),
                                                            ])
                                                            ->columns(2),
                                                    ])
                                                    ->visible(fn(?Member $record) => $record?->ispconfigs()
                                                        ->where('type', IspconfigType::MAIL)
                                                        ->exists()
                                                    ),

                                                /*
                                                 | Hébergements web ISPConfig
                                                 */
                                                Section::make('Hébergements Web')
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('ispconfigs_web')
                                                            ->label('')
                                                            ->state(fn(?Member $record) => $record?->ispconfigs()
                                                                ->where('type', IspconfigType::WEB)
                                                                ->get()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('data.web_domain.domain')
                                                                    ->label('Domaine'),

                                                                TextEntry::make('data.web_domain.ip_address')
                                                                    ->label('Adresse IP'),

                                                                TextEntry::make('data.web_domain.disk_quota')
                                                                    ->label('Quota disque')
                                                                    ->formatStateUsing(fn($state) => $state ? "{$state} Mo" : '—'
                                                                    ),
                                                            ])
                                                            ->columns(3),
                                                    ])
                                                    ->visible(fn(?Member $record) => $record?->ispconfigs()
                                                        ->where('type', IspconfigType::WEB)
                                                        ->exists()
                                                    ),
                                            ]),
                                    ]),
                            ])
                            ->columnSpan(3),

                        /*
                         |--------------------------------------------------------------------------
                         | Colonne latérale
                         |--------------------------------------------------------------------------
                         */
                        Grid::make(1)
                            ->schema([
                                Section::make('Statut')
                                    ->collapsible()
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
                                    ->extraAttributes(['class' => 'sticky top-4 h-fit']),

                                Section::make('Actions')
                                    ->collapsible()
                                    ->schema([
                                        Action::make('send-payment-mail')
                                            ->label('Envoyer le mail de paiement')
                                            ->icon('heroicon-o-envelope')
                                            ->action(function () {
                                                // Mail de paiement pour nouvelle inscription (Job)
                                            }),

                                        Action::make('send-renewal-mail')
                                            ->label('Envoyer un mail de relance')
                                            ->icon('heroicon-o-envelope')
                                            ->action(function () {
                                                // Mail de relance à créer (Job)
                                            }),
                                    ])
                                    ->extraAttributes(['class' => 'sticky top-4 h-fit']),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }
}
