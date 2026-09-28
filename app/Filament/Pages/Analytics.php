<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Analytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Inbox';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.analytics';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\AnalyticsOverview::class,
            \App\Filament\Widgets\ViewsChart::class,
            \App\Filament\Widgets\TopPages::class,
        ];
    }
}