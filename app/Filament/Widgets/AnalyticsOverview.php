<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnalyticsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $today = PageView::whereDate('created_at', today());
        $yesterday = PageView::whereDate('created_at', today()->subDay());
        $last7 = PageView::where('created_at', '>=', now()->subDays(7));
        $last30 = PageView::where('created_at', '>=', now()->subDays(30));

        $todayCount = $today->count();
        $yesterdayCount = $yesterday->count();

        $trend = $yesterdayCount > 0
            ? round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100, 1)
            : 0;

        return [
            Stat::make('Views today', $todayCount)
                ->description($trend >= 0 ? "↑ {$trend}% vs yesterday" : "↓ {$trend}% vs yesterday")
                ->descriptionIcon($trend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($trend >= 0 ? 'success' : 'danger'),

            Stat::make('Last 7 days', $last7->count())
                ->description('Total page views')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),

            Stat::make('Last 30 days', $last30->count())
                ->description('Total page views')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            Stat::make('Unique visitors (30d)', PageView::where('created_at', '>=', now()->subDays(30))
                ->distinct('ip_hash')
                ->count('ip_hash'))
                ->description('Unique IPs')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
        ];
    }
}