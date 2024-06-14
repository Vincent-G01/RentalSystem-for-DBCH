<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Halls;
use App\Models\Events;
use App\Models\Facilities;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Event_Facility_Rental;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventFacilityRentalResource\Pages;
use App\Filament\Resources\EventFacilityRentalResource\RelationManagers;


class EventFacilityRentalResource extends Resource
{
    protected static ?string $model = Event_Facility_Rental::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'System Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('halls_id')
                    ->label('Hall name')
                    ->required()
                    ->preload()
                    ->options(function () {
                        return Halls::pluck('name', 'id')->toArray();  // yang ini ikut nama model awak ('name','name') => (label yang akan di display, data yang akan disimpan)
                    }),

                Forms\Components\Select::make('events_id')
                    ->label('Event name')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->options(function () {
                        return Events::pluck('name', 'id')->toArray();  // yang ini ikut nama model awak ('name','name') => (label yang akan di display, data yang akan disimpan)
                    }),

                Forms\Components\TextInput::make('event_rental_rate')
                    ->label('Event rental rate')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('facilities_id')
                    ->label('Facility name')
                    ->searchable()
                    // ->required()
                    ->preload()
                    ->options(function () {
                        return Facilities::pluck('name', 'id')->toArray();  // yang ini ikut nama model awak ('name','name') => (label yang akan di display, data yang akan disimpan)
                    }),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    // ->required()
                    ->numeric(),
                    
                Forms\Components\TextInput::make('facility_rental_rate')
                    ->label('Facility rental rate')
                    // >required()
                    ->numeric(),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('halls.name')
                    ->label('Hall')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('events.name')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_rental_rate')
                    ->label('Event rental rate')
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('facilities.name')
                    ->label('Facility')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('facility_rental_rate')
                    ->searchable()
                    ->sortable(),
               
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListEventFacilityRentals::route('/'),
            'create' => Pages\CreateEventFacilityRental::route('/create'),
            'edit' => Pages\EditEventFacilityRental::route('/{record}/edit'),
        ];
    }
}
