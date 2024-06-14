<?php

namespace App\Filament\Resources\CourtRentalResource\Pages;

use App\Filament\Resources\CourtRentalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourtRental extends EditRecord
{
    protected static string $resource = CourtRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
