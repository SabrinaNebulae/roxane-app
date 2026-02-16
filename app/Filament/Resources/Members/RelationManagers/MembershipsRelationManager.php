<?php

namespace App\Filament\Resources\Members\RelationManagers;

use App\Models\Membership;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembershipsRelationManager extends RelationManager
{
    protected static string $relationship = 'memberships';

    protected static ?string $title = 'Adhésions';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_date')
            ->columns([
                TextColumn::make('start_date')
                    ->label(Membership::getAttributeLabel('start_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(Membership::getAttributeLabel('end_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(Membership::getAttributeLabel('status'))
                    ->formatStateUsing(fn (string $state) => Membership::getAttributeLabel($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'expired' => 'danger',
                        'pending' => 'warning',
                    }),
                TextColumn::make('package.name')
                    ->label(Membership::getAttributeLabel('package_id')),
                TextColumn::make('amount')
                    ->label(Membership::getAttributeLabel('amount'))
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label(Membership::getAttributeLabel('payment_status'))
                    ->formatStateUsing(fn (string $state) => Membership::getAttributeLabel($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->label(Membership::getAttributeLabel('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
