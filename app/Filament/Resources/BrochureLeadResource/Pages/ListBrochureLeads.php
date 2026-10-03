<?php

namespace App\Filament\Resources\BrochureLeadResource\Pages;

use App\Filament\Resources\BrochureLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrochureLeads extends ListRecords
{
    protected static string $resource = BrochureLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
