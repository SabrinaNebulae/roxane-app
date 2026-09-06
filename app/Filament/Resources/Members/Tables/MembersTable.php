<?php

namespace App\Filament\Resources\Members\Tables;

use App\Models\Member;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lastname')
                    ->label(Member::getAttributeLabel('lastname'))
                    ->searchable(),
                TextColumn::make('firstname')
                    ->label(Member::getAttributeLabel('firstname'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(Member::getAttributeLabel('email'))
                    ->searchable(),
                TextColumn::make('status')
                    ->label(Member::getAttributeLabel('status'))
                    ->formatStateUsing(fn (string $state) => Member::getAttributeLabel($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'valid' => 'success',
                        'cancelled' => 'danger',
                        'excluded' => 'black',
                    }),
                TextColumn::make('group.name')
                    ->label(Member::getAttributeLabel('group_id'))
                    ->numeric()
                    ->sortable(),
                IconColumn::make('public_membership')
                    ->label(Member::getAttributeLabel('public_membership'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(Member::getAttributeLabel('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Member::getAttributeLabel('updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(Member::getAttributeLabel('deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(Member::getAttributeLabel('status'))
                    ->multiple()
                    ->options([
                        'draft' => Member::getAttributeLabel('draft'),
                        'pending' => Member::getAttributeLabel('pending'),
                        'valid' => Member::getAttributeLabel('valid'),
                        'cancelled' => Member::getAttributeLabel('cancelled'),
                        'excluded' => Member::getAttributeLabel('excluded'),
                    ]),
                SelectFilter::make('group.name')
                    ->label(Member::getAttributeLabel('group_id'))->multiple()
                    ->relationship('group', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
