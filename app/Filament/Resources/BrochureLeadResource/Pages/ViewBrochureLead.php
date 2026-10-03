<?php

namespace App\Filament\Resources\BrochureLeadResource\Pages;

use App\Filament\Resources\BrochureLeadResource;
use Filament\Resources\Pages\ViewRecord;

class ViewBrochureLead extends ViewRecord
{
    protected static string $resource = BrochureLeadResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->markAsRead();
        return $data;
    }
}