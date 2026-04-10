<?php

namespace App\Filament\Widgets;

use App\Models\Membership;
use Filament\Widgets\ChartWidget;

class MembershipsPerMonthChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Adhésions par mois';

    protected ?string $description = 'Nouvelles adhésions sur les 12 derniers mois';

    protected ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $data = collect(range(11, 0))->map(function (int $monthsAgo) {
            $date = now()->subMonths($monthsAgo);

            return [
                'month' => $date->translatedFormat('M Y'),
                'count' => Membership::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Adhésions',
                    'data' => $data->pluck('count')->toArray(),
                    'borderColor' => 'rgb(244, 63, 94)',
                    'backgroundColor' => 'rgba(244, 63, 94, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
