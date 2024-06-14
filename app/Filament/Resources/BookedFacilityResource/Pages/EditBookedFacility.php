<?php

namespace App\Filament\Resources\BookedFacilityResource\Pages;

use App\Filament\Resources\BookedFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookedFacility extends EditRecord
{
    protected static string $resource = BookedFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
