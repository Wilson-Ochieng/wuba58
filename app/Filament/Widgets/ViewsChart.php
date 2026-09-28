<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;

class ViewsChart extends ChartWidget
{
    protected static ?string $heading = 'Page views — last 30 days';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(fn ($i) => now()->subDays($i));

        $counts = $days->map(function ($day) {
            return PageView::whereDate('created_at', $day)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => $counts->toArray(),
                    'borderColor' => '#ECB143',
                    'backgroundColor' => 'rgba(236, 177, 67, 0.15)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $days->map(fn ($d) => $d->format('M j'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}