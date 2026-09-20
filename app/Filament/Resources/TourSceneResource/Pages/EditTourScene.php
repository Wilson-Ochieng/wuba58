<?php

namespace App\Filament\Resources\TourSceneResource\Pages;

use App\Filament\Resources\TourSceneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourScene extends EditRecord
{
    protected static string $resource = TourSceneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
