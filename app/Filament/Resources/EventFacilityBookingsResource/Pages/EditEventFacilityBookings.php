<?php

namespace App\Filament\Resources\EventFacilityBookingsResource\Pages;

use App\Filament\Resources\EventFacilityBookingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventFacilityBookings extends EditRecord
{
    protected static string $resource = EventFacilityBookingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
