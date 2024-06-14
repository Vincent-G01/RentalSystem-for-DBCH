<?php

namespace App\Filament\Resources\EventFacilityRentalResource\Pages;

use App\Filament\Resources\EventFacilityRentalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventFacilityRental extends EditRecord
{
    protected static string $resource = EventFacilityRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
