<?php

namespace App\Filament\Resources\BookedFacilityResource\Pages;

use App\Filament\Resources\BookedFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookedFacilities extends ListRecords
{
    protected static string $resource = BookedFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
