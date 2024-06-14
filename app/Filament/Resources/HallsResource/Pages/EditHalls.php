<?php

namespace App\Filament\Resources\HallsResource\Pages;

use App\Filament\Resources\HallsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHalls extends EditRecord
{
    protected static string $resource = HallsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
