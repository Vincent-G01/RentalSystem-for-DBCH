<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourtRentalResource\Pages;
use App\Filament\Resources\CourtRentalResource\RelationManagers;
use App\Models\Court_Rental;
use App\Models\Halls;
use App\Models\Sports;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourtRentalResource extends Resource
{
    protected static ?string $model = Court_Rental::class;

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
                Forms\Components\Select::make('sports_id')
                    ->label('Sport name')
                    ->required()
                    ->preload()
                    ->options(function () {
                        return Sports::pluck('name', 'id')->toArray();  // yang ini ikut nama model awak ('name','name') => (label yang akan di display, data yang akan disimpan)
                    }),
                Forms\Components\TextInput::make('number_of_court')
                    ->label('Number of court')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('sport_rental_rate')
                    ->label('Sport rental rate')
                    ->numeric()
                    ->required(),
                    
                    
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
                Tables\Columns\TextColumn::make('sports.name')
                    ->label('Sport')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_court')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sport_rental_rate')
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
            'index' => Pages\ListCourtRentals::route('/'),
            'create' => Pages\CreateCourtRental::route('/create'),
            'edit' => Pages\EditCourtRental::route('/{record}/edit'),
        ];
    }
}
