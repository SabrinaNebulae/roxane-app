<?php

namespace App\Filament\Resources\MemberGroups\Schemas;

use App\Models\MemberGroup;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MemberGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(fn (?MemberGroup $record) => $record?->name ?? MemberGroup::getAttributeLabel('name'))
                    ->headerActions([
                        Action::make('view-members')
                            ->icon('heroicon-o-users')
                            ->label(MemberGroup::getAttributeLabel('view_members'))
                            ->action(function (MemberGroup $record) {
                                return redirect()->route('filament.admin.resources.members.index', ['filters[group][name][values][0]' => $record->id]);
                            })
                            ->visible(fn (?MemberGroup $record) => $record !== null),

                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label(MemberGroup::getAttributeLabel('name'))
                            ->required(),
                        TextInput::make('identifier')
                            ->label(MemberGroup::getAttributeLabel('identifier'))
                            ->disabledOn('edit')
                            ->required(),
                        Textarea::make('description')
                            ->label(MemberGroup::getAttributeLabel('description'))
                            ->default(null),
                    ]),
            ]);
    }
}
