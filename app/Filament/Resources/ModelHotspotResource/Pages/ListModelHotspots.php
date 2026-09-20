<?php

namespace App\Filament\Resources\ModelHotspotResource\Pages;

use App\Filament\Resources\ModelHotspotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModelHotspots extends ListRecords
{
    protected static string $resource = ModelHotspotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
