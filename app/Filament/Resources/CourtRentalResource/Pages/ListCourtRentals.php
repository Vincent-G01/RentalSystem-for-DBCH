<?php

namespace App\Filament\Resources\CourtRentalResource\Pages;

use App\Filament\Resources\CourtRentalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourtRentals extends ListRecords
{
    protected static string $resource = CourtRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
