<?php

namespace App\Filament\Resources\Members\Widgets;

use App\Models\Member;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberCount extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(Member::getAttributeLabel('widgets.stats.name'), Member::count())
                ->description(Member::getAttributeLabel('widgets.stats.description'))
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
        ];
    }
}
