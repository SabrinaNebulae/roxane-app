<?php

namespace App\Filament\Resources\NotificationTemplates\Tables;

use App\Models\NotificationTemplate;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotificationTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(NotificationTemplate::getAttributeLabel('name'))
                    ->searchable(),
                TextColumn::make('identifier')
                    ->label(NotificationTemplate::getAttributeLabel('identifier'))
                    ->searchable(),
                TextColumn::make('subject')
                    ->label(NotificationTemplate::getAttributeLabel('subject'))
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label(NotificationTemplate::getAttributeLabel('is_active'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
