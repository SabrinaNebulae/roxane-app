<?php

namespace App\Filament\Resources\Memberships\Tables;

use App\Models\Membership;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembershipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('id')
                    ->sortable(),
                TextColumn::make('member.full_name')
                    ->label(Membership::getAttributeLabel('member_id'))
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label(Membership::getAttributeLabel('admin_id'))
                    ->numeric()
                    ->sortable(),
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
                        'pending' => 'warning',
                        'active' => 'success',
                        'expired' => 'danger',
                    }),
                TextColumn::make('amount')
                    ->label(Membership::getAttributeLabel('amount'))
                    ->money('euro')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label(Membership::getAttributeLabel('payment_status'))
                    ->formatStateUsing(fn (string $state) => Membership::getAttributeLabel($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'partial' => 'warning',
                        'paid' => 'success',
                        'unpaid' => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label(Membership::getAttributeLabel('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(Membership::getAttributeLabel('updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->searchable([
                'member.firstname',
                'member.lastname',
                'author.name',
                'status',
                'payment_status',
                'amount',
            ])
            ->filters([
                // Filtres pour status, date de début et date de fin, status de paiement

                QueryBuilder::make()
                    ->constraints([
                        SelectConstraint::make('status')
                            ->label('Statut de l\'adhésion')
                            ->options([
                                'active' => 'Active',
                                'expired' => 'Expirée',
                                'pending' => 'En attente',
                            ]),
                        DateConstraint::make('start_date')
                            ->label('Date de début'),
                        DateConstraint::make('end_date')
                            ->label('Date de fin'),
                        SelectConstraint::make('payment_status')
                            ->label('Statut de paiement')
                            ->options([
                                'paid' => 'Payée',
                                'unpaid' => 'Impayée',
                                'partial' => 'Partiellement payée'
                            ]),
                ]),
            ], layout: FiltersLayout::Modal)
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
