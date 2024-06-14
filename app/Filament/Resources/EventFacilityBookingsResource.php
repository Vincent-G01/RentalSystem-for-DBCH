<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventFacilityBookingsResource\Pages;
use App\Filament\Resources\EventFacilityBookingsResource\RelationManagers;
use App\Models\Event_Facility_Bookings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventFacilityBookingsResource extends Resource
{
    protected static ?string $model = Event_Facility_Bookings::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventFacilityBookings::route('/'),
            'create' => Pages\CreateEventFacilityBookings::route('/create'),
            'edit' => Pages\EditEventFacilityBookings::route('/{record}/edit'),
        ];
    }
}
