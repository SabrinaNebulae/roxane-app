<?php

namespace App\Filament\Resources\Memberships\Schemas;

use App\Enums\IspconfigType;
use App\Filament\Actions\ServiceToggleAction;
use App\Models\ListmonkMember;
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
                                        Tabs\Tab::make(__('memberships.tabs.general_info'))
                                            ->icon(Heroicon::OutlinedInformationCircle)
                                            ->schema([
                                                Section::make(__('memberships.sections.member'))
                                                    ->headerActions([
                                                        Action::make('view-profile')
                                                            ->icon('heroicon-o-user')
                                                            ->label(__('memberships.actions.view_profile'))
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

                                                Section::make(__('memberships.sections.transaction'))
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
                                        Tabs\Tab::make(__('memberships.tabs.modules'))
                                            ->icon(Heroicon::OutlinedPuzzlePiece)
                                            ->schema([
                                                Section::make(__('memberships.sections.ispconfig_mail'))
                                                    ->afterHeader([
                                                        ServiceToggleAction::forService('mail'),
                                                    ])
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('ispconfig_mails')
                                                            ->label(__('members.ispconfig.mail_data'))
                                                            ->state(fn (?Membership $record) => $record?->member?->ispconfigs()
                                                                ->where('type', IspconfigType::MAIL)
                                                                ->get()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('email')
                                                                    ->label(__('members.ispconfig.email')),

                                                                TextEntry::make('ispconfig_service_user_id')
                                                                    ->label(__('members.ispconfig.id')),

                                                                TextEntry::make('data.mailuser.quota')
                                                                    ->label(__('members.ispconfig.quota')),

                                                                TextEntry::make('data.mailuser.domain')
                                                                    ->label(__('members.ispconfig.domain'))
                                                                    ->default('retzien.fr'),

                                                                ViewEntry::make('data')
                                                                    ->label('JSON')
                                                                    ->view('filament.components.json-viewer')
                                                                    ->viewData(fn ($state) => [
                                                                        'data' => $state,
                                                                    ])
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns(2),
                                                    ]),

                                                Section::make(__('memberships.sections.ispconfig_web'))
                                                    ->afterHeader([
                                                        ServiceToggleAction::forService('webhosting'),
                                                    ])
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('ispconfigs_web')
                                                            ->label(__('members.ispconfig.web_data'))
                                                            ->state(fn (?Membership $record) => $record?->member?->ispconfigs()
                                                                ->where('type', IspconfigType::WEB)
                                                                ->get()
                                                                ->map(fn ($ispconfig) => $ispconfig->toArray())
                                                                ->all()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('data.domain_id')
                                                                    ->label(__('members.ispconfig.id')),

                                                                TextEntry::make('data.domain')
                                                                    ->label(__('members.ispconfig.domain')),

                                                                TextEntry::make('data.active')
                                                                    ->label(__('members.ispconfig.state'))
                                                                    ->formatStateUsing(fn ($state) => $state === 'y'
                                                                        ? __('members.ispconfig.enabled')
                                                                        : __('members.ispconfig.disabled')
                                                                    ),

                                                                ViewEntry::make('data')
                                                                    ->label('JSON')
                                                                    ->view('filament.components.json-viewer')
                                                                    ->viewData(fn ($state) => [
                                                                        'data' => $state,
                                                                    ])
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns(3),
                                                    ]),

                                                Section::make(__('memberships.sections.nextcloud'))
                                                    ->afterHeader([
                                                        ServiceToggleAction::forService('nextcloud'),
                                                    ])
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('nextcloud_accounts')
                                                            ->label(__('members.ispconfig.nextcloud_data'))
                                                            ->state(fn (?Membership $record) => $record?->member?->nextcloudAccounts()
                                                                ->get()
                                                                ->map(fn ($nextcloudAccount) => $nextcloudAccount->toArray())
                                                                ->all()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('nextcloud_user_id')
                                                                    ->label(__('members.ispconfig.nextcloud_id')),

                                                                TextEntry::make('data.displayname')
                                                                    ->label(__('members.ispconfig.display_name')),

                                                                TextEntry::make('data.enabled')
                                                                    ->label(__('members.ispconfig.state'))
                                                                    ->formatStateUsing(fn ($state) => $state == 'true'
                                                                        ? __('members.ispconfig.enabled')
                                                                        : __('members.ispconfig.disabled')
                                                                    ),

                                                                ViewEntry::make('data')
                                                                    ->label('JSON')
                                                                    ->view('filament.components.json-viewer')
                                                                    ->viewData(fn ($state) => [
                                                                        'data' => $state,
                                                                    ])
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns(3),
                                                    ]),

                                                Section::make(__('memberships.sections.listmonk'))
                                                    ->afterHeader([
                                                        ServiceToggleAction::forService('listmonk'),
                                                    ])
                                                    ->collapsible()
                                                    ->schema([
                                                        RepeatableEntry::make('listmonk_accounts')
                                                            ->label(__('members.ispconfig.listmonk_data'))
                                                            ->state(fn (?Membership $record) => $record?->member?->listmonkMembers()
                                                                ->get()
                                                                ->map(fn (ListmonkMember $lm) => $lm->toArray())
                                                                ->all()
                                                            )
                                                            ->schema([
                                                                TextEntry::make('listmonk_user_id')
                                                                    ->label(__('members.ispconfig.listmonk_id')),
                                                                ViewEntry::make('data')
                                                                    ->label('JSON')
                                                                    ->view('filament.components.json-viewer')
                                                                    ->viewData(fn ($state) => [
                                                                        'data' => $state,
                                                                    ])
                                                                    ->columnSpanFull(),
                                                            ])
                                                            ->columns(2),
                                                    ]),
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
                                Section::make(__('memberships.sections.status'))
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
