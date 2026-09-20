<?php

namespace App\Filament\Resources\TourHotspotResource\Pages;

use App\Filament\Resources\TourHotspotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourHotspot extends EditRecord
{
    protected static string $resource = TourHotspotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
