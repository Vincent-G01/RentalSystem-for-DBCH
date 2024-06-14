<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookedFacilityResource\Pages;
use App\Filament\Resources\BookedFacilityResource\RelationManagers;
use App\Models\Booked_Facility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookedFacilityResource extends Resource
{
    protected static ?string $model = Booked_Facility::class;

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
            'index' => Pages\ListBookedFacilities::route('/'),
            'create' => Pages\CreateBookedFacility::route('/create'),
            'edit' => Pages\EditBookedFacility::route('/{record}/edit'),
        ];
    }
}
