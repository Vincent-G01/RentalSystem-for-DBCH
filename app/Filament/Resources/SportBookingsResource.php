<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SportBookingsResource\Pages;
use App\Filament\Resources\SportBookingsResource\RelationManagers;
use App\Models\Sport_Bookings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SportBookingsResource extends Resource
{
    protected static ?string $model = Sport_Bookings::class;

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
                Tables\Columns\TextColumn::make('users.name')
                ->label('Name')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('halls.name')
                ->label('Hall')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('sports.name')
                ->label('Sport')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('use_date')
                ->label('Use date')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('start_time')
                ->label('Start time')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('end_time')
                ->label('End time')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                ->label('Total amount')
                
                ->sortable(),

                Tables\Columns\TextColumn::make('confirmed'),
                

                Tables\Columns\TextColumn::make('reserved_at'),
                

            ])
            ->filters([
               
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
            'index' => Pages\ListSportBookings::route('/'),
            'create' => Pages\CreateSportBookings::route('/create'),
            'edit' => Pages\EditSportBookings::route('/{record}/edit'),
        ];
    }
}
