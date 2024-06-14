<?php

namespace App\Filament\Resources\SportBookingsResource\Pages;

use App\Filament\Resources\SportBookingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSportBookings extends ListRecords
{
    protected static string $resource = SportBookingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
