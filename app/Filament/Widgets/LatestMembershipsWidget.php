<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Memberships\MembershipResource;
use App\Models\Membership;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestMembershipsWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Dernières adhésions';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Membership::query()
                    ->with(['member', 'package'])
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('member.full_name')
                    ->label('Adhérent')
                    ->searchable(['members.firstname', 'members.lastname']),

                TextColumn::make('package.name')
                    ->label('Package'),

                TextColumn::make('status')
                    ->label('Statut adhésion')
                    ->formatStateUsing(fn (string $state) => Membership::getAttributeLabel($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'expired' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('payment_status')
                    ->label('Paiement')
                    ->formatStateUsing(fn (string $state) => Membership::getAttributeLabel($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('amount')
                    ->label('Montant')
                    ->money('EUR'),

                TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('edit')
                    ->label('Voir')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (Membership $record): string => MembershipResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated(false);
    }
}
