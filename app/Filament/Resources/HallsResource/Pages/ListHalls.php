<?php

namespace App\Filament\Resources\HallsResource\Pages;

use App\Filament\Resources\HallsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHalls extends ListRecords
{
    protected static string $resource = HallsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
