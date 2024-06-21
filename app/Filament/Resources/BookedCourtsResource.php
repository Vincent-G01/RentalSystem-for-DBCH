<?php

// namespace App\Filament\Resources;

// use App\Filament\Resources\BookedCourtsResource\Pages;
// use App\Filament\Resources\BookedCourtsResource\RelationManagers;
// use App\Models\Booked_Courts;
// use Filament\Forms;
// use Filament\Forms\Form;
// use Filament\Resources\Resource;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

// class BookedCourtsResource extends Resource
// {
//     protected static ?string $model = Booked_Courts::class;

//     protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

//     public static function form(Form $form): Form
//     {
//         return $form
//             ->schema([
//                 //
//             ]);
//     }

//     public static function table(Table $table): Table
//     {
//         return $table
//             ->columns([
//                 Tables\Columns\TextColumn::make('sport_booking_id')
//                 // ->label('Hall')
//                 ->searchable()
//                 ->sortable(),

//                 Tables\Columns\TextColumn::make('court_number')
//                 ->label('Rented Court'),
//                 // ->searchable()
//                 // ->sortable(),
//             ])
//             ->filters([
                
//             ])
//             ->actions([
//                 Tables\Actions\EditAction::make(),
//                 Tables\Actions\DeleteAction::make(),
//             ])
//             ->bulkActions([
//                 Tables\Actions\BulkActionGroup::make([
//                     Tables\Actions\DeleteBulkAction::make(),
//                 ]),
//             ]);
//     }

//     public static function getRelations(): array
//     {
//         return [
//             //
//         ];
//     }

//     public static function getPages(): array
//     {
//         return [
//             'index' => Pages\ListBookedCourts::route('/'),
//             'create' => Pages\CreateBookedCourts::route('/create'),
//             'edit' => Pages\EditBookedCourts::route('/{record}/edit'),
//         ];
//     }
// }
