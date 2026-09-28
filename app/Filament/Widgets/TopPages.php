<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class TopPages extends TableWidget
{
    protected static ?string $heading = 'Top pages — last 30 days';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PageView::query()
                    ->selectRaw('MIN(id) as id, path, COUNT(*) as views, COUNT(DISTINCT ip_hash) as visitors')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('path')
                    ->orderByDesc('views')
                    ->limit(15)
            )
            ->columns([
                Tables\Columns\TextColumn::make('path')
                    ->label('Page')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('views')
                    ->label('Views')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('visitors')
                    ->label('Unique')
                    ->badge()
                    ->color('gray'),
            ]);
    }
}