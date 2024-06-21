<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventFacilityBookingsResource\Pages;
use App\Filament\Resources\EventFacilityBookingsResource\RelationManagers;
use App\Models\Event_Facility_Bookings;
use Filament\Actions\DeleteAction;
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
                Tables\Columns\TextColumn::make('users_id')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('halls.name')
                    ->label('Hall')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('events.name')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('use_date')
                    ->label('Use Date')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->sortable(),

                // Add facility and quantity
                Tables\Columns\TextColumn::make('bookedFacilities.facility.name')
                    ->label('Facility')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('bookedFacilities.quantity')
                    ->label('Quantity')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('confirmed')
                    ->label('Confirmed')
                    ->boolean()
                    // ->trueIcon('heroicon-o-check-circle')
                    // ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reserved_at'),

                
            ])
            ->filters([
                Tables\Filters\Filter::make('Confirmed')
                    ->query(fn (Builder $query) => $query->where('confirmed', 1)),
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
            'index' => Pages\ListEventFacilityBookings::route('/'),
            'create' => Pages\CreateEventFacilityBookings::route('/create'),
            'edit' => Pages\EditEventFacilityBookings::route('/{record}/edit'),
        ];
    }
}
