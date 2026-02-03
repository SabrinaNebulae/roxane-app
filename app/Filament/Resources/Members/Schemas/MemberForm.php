<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Enums\IspconfigType;
use App\Models\Member;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Icons\Heroicon;
use App\Filament\Actions\ServiceToggleAction;

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
                                            ->icon(Heroicon::OutlinedInformationCircle)
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
                                            ->icon(Heroicon::OutlinedPuzzlePiece)
                                            ->schema([
                                                /*
                                                 | Messageries ISPConfig (lecture seule)
                                                 */
                                                Section::make('Messagerie ISPConfig')
                                                    ->afterHeader([
                                                        ServiceToggleAction::forService('mail'),
                                                    ])
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('ispconfig_mails')
                                                            ->label('Données ISPConfig Mail')
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
                                                                    ->label('Quota'),
                                                                //->formatStateUsing(fn($state) => $state ? "{$state} Mo" : 'Non défini'
                                                                //),

                                                                TextEntry::make('data.mailuser.domain')
                                                                    ->label('Domaine')
                                                                    ->default('retzien.fr'),
                                                                ViewEntry::make('data')
                                                                    ->label('JSON')
                                                                    ->view('filament.components.json-viewer')
                                                                    ->viewData(fn($state) => [
                                                                        'data' => $state,
                                                                    ])
                                                                    ->columnSpanFull(),
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
                                                    ->afterHeader([
                                                        ServiceToggleAction::forService('webhosting'),
                                                    ])
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('ispconfigs_web')
                                                            ->label('Données ISPConfig Web')
                                                            ->state(fn(?Member $record) => $record?->ispconfigs()
                                                                ->where('type', IspconfigType::WEB)
                                                                ->get()
                                                                ->map(fn($ispconfig) => $ispconfig->toArray())
                                                                ->all()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('data.domain_id')
                                                                    ->label('ID ISPConfig'),

                                                                TextEntry::make('data.domain')
                                                                    ->label('Domaine'),

                                                                TextEntry::make('data.active')
                                                                    ->label('État')
                                                                    ->formatStateUsing(fn($state) => $state === 'y' ? 'Activé' : 'Désactivé'
                                                                    ),
                                                                ViewEntry::make('data')
                                                                    ->label('JSON')
                                                                    ->view('filament.components.json-viewer')
                                                                    ->viewData(fn($state) => [
                                                                        'data' => $state,
                                                                    ])
                                                                    ->columnSpanFull(),
                                                                    // @todo: background color : #F5F8FA
                                                            ])
                                                            ->columns(3),

                                                    ])
                                                    ->visible(fn(?Member $record) => $record?->ispconfigs()
                                                        ->where('type', IspconfigType::WEB)
                                                        ->exists()
                                                    ),

                                                /*
                                                 | Compte(s) NextCloud (lecture seule)
                                                 */
                                                Section::make('NextCloud')
                                                    ->afterHeader([
                                                        ServiceToggleAction::forService('nextcloud'),
                                                    ])
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('nextcloud_accounts')
                                                            ->label('Données NextCloud')
                                                            ->state(fn(?Member $record) => $record?->nextcloudAccounts()
                                                                ->get()
                                                                ->map(fn($nextcloudAccount) => $nextcloudAccount->toArray())
                                                                ->all()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('nextcloud_user_id')
                                                                    ->label('Id Nextcloud'),

                                                                TextEntry::make('data.displayname')
                                                                    ->label('Nom de l\'utilisateur'),

                                                                TextEntry::make('data.enabled')
                                                                    ->label('État')
                                                                    ->formatStateUsing(fn($state) => $state == 'true' ? 'Activé' : 'Désactivé'
                                                                    ),

                                                                ViewEntry::make('data')
                                                                    ->label('JSON')
                                                                    ->view('filament.components.json-viewer')
                                                                    ->viewData(fn($state) => [
                                                                        'data' => $state,
                                                                    ])
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns(3),
                                                    ])
                                                    ->visible(fn(?Member $record) => $record?->nextcloudAccounts()
                                                        ->exists()
                                                    ),
                                            ]),
                                    ])
                                ->contained(false)
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
