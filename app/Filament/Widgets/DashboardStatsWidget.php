<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use App\Models\Membership;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $activeMembers = Member::where('status', 'valid')->count();
        $activeMemberships = Membership::where('status', 'active')->count();
        $newThisMonth = Membership::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $unpaidMemberships = Membership::where('payment_status', 'unpaid')
            ->where('status', 'active')
            ->count();

        return [
            Stat::make('Membres actifs', $activeMembers)
                ->description('Statut "Valide"')
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)
                ->color('success'),

            Stat::make('Adhésions actives', $activeMemberships)
                ->description('En cours')
                ->descriptionIcon('heroicon-o-identification', IconPosition::Before)
                ->color('primary'),

            Stat::make('Nouvelles adhésions', $newThisMonth)
                ->description('Ce mois-ci')
                ->descriptionIcon('heroicon-o-calendar', IconPosition::Before)
                ->color('info'),

            Stat::make('Paiements en attente', $unpaidMemberships)
                ->description('Adhésions actives non réglées')
                ->descriptionIcon('heroicon-o-banknotes', IconPosition::Before)
                ->color($unpaidMemberships > 0 ? 'warning' : 'success'),
        ];
    }
}
