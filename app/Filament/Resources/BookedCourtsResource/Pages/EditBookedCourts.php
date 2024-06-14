<?php

namespace App\Filament\Resources\BookedCourtsResource\Pages;

use App\Filament\Resources\BookedCourtsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookedCourts extends EditRecord
{
    protected static string $resource = BookedCourtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
