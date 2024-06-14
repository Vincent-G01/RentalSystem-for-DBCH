<?php

namespace App\Filament\Resources\BookedCourtsResource\Pages;

use App\Filament\Resources\BookedCourtsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookedCourts extends ListRecords
{
    protected static string $resource = BookedCourtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
