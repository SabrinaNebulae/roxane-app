<?php

namespace App\Filament\Resources\Memberships\Schemas;

use App\Enums\IspconfigType;
use App\Filament\Actions\ServiceToggleAction;
use App\Models\Membership;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class MembershipForm
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
                                Tabs::make('MembershipTabs')
                                    ->tabs([
                                        /*
                                         |--------------------------------------------------------------------------
                                         | TAB : Informations générales
                                         |--------------------------------------------------------------------------
                                         */
                                        Tabs\Tab::make('Informations générales')
                                            ->icon(Heroicon::OutlinedInformationCircle)
                                            ->schema([
                                                Section::make('Adhérent')
                                                    ->headerActions([
                                                        Action::make('view-profile')
                                                            ->icon('heroicon-o-user')
                                                            ->label('Voir le profil du membre')
                                                            ->action(function (Membership $record) {
                                                                return redirect()->route('filament.admin.resources.members.edit', ['record' => $record->member_id]);
                                                            }),
                                                    ])
                                                    ->schema([
                                                        TextEntry::make('member.full_name')
                                                            ->label(Membership::getAttributeLabel('member_id')),
                                                        TextEntry::make('author.name')
                                                            ->label(Membership::getAttributeLabel('admin_id')),
                                                        TextEntry::make('created_at')
                                                            ->label(Membership::getAttributeLabel('created_at')),
                                                    ])
                                                    ->columns(2),

                                                Section::make('Informations de transaction')
                                                    ->schema([
                                                        Select::make('package_id')
                                                            ->label(Membership::getAttributeLabel('package_id'))
                                                            ->placeholder(Membership::getAttributeLabel('select_package'))
                                                            ->relationship('package', 'name')
                                                            ->required()
                                                            ->default(null),
                                                        Select::make('payment_status')
                                                            ->label(Membership::getAttributeLabel('payment_status'))
                                                            ->options(['paid' => Membership::getAttributeLabel('paid'), 'unpaid' => Membership::getAttributeLabel('unpaid'), 'partial' => Membership::getAttributeLabel('partial')])
                                                            ->default('unpaid')
                                                            ->required(),
                                                        TextInput::make('amount')
                                                            ->label(Membership::getAttributeLabel('amount'))
                                                            ->required()
                                                            ->numeric('decimal')
                                                            ->default(0.0),
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
                                                            ->state(fn(?Membership $record) => $record?->member?->ispconfigs()
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
                                                    ->visible(fn(?Membership $record) => $record?->member?->ispconfigs()
                                                        ->where('type', IspconfigType::MAIL)
                                                        ->exists() ?? false
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
                                                            ->state(fn(?Membership $record) => $record?->member?->ispconfigs()
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
                                                            ])
                                                            ->columns(3),
                                                    ])
                                                    ->visible(fn(?Membership $record) => $record?->member?->ispconfigs()
                                                        ->where('type', IspconfigType::WEB)
                                                        ->exists() ?? false
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
                                                            ->state(fn(?Membership $record) => $record?->member?->nextcloudAccounts()
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
                                                    ->visible(fn(?Membership $record) => $record?->member?->nextcloudAccounts()
                                                        ->exists() ?? false
                                                    ),
                                            ]),
                                    ])
                                    ->contained(false),
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
                                    ->schema([
                                        Select::make('status')
                                            ->label(Membership::getAttributeLabel('status'))
                                            ->options(['active' => Membership::getAttributeLabel('active'), 'expired' => Membership::getAttributeLabel('expired'), 'pending' => Membership::getAttributeLabel('pending')])
                                            ->default('pending')
                                            ->required(),
                                        DatePicker::make('start_date')
                                            ->label(Membership::getAttributeLabel('start_date'))
                                            ->required(),
                                        DatePicker::make('end_date')
                                            ->label(Membership::getAttributeLabel('end_date')),
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
