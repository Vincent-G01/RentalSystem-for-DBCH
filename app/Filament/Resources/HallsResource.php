<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HallsResource\Pages;
use App\Filament\Resources\HallsResource\RelationManagers;
use App\Models\City;
use App\Models\Halls;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class HallsResource extends Resource
{
    protected static ?string $model = Halls::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'System Configuration';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('diagram')
                    // ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->required(),
                    
                    // ->maxLength(255),
                Forms\Components\Select::make('cities_id')
                    ->label('City name')
                    ->required()
                    ->preload()
                    ->options(function () {
                        return City::pluck('name', 'id')->toArray();  // yang ini ikut nama model awak ('name','name') => (label yang akan di display, data yang akan disimpan)
                    }),
                    // ->numeric(),
                Forms\Components\TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('users_id')
                    ->label('Staff')
                    ->required()
                    ->preload()
                    ->options(function () {
                        return User::where('role', 'Staff Onsite')->pluck('name', 'id')->toArray();  // yang ini ikut nama model awak ('name','name') => (label yang akan di display, data yang akan disimpan)
                    }),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->required(),
                    
                
                Forms\Components\Toggle::make('maintainance_status')
                    ->required(),
                Forms\Components\DatePicker::make('maintainance_start_date'),
                    
                    // ->maxDate(now()),
                    
                Forms\Components\DatePicker::make('maintainance_end_date')
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('diagram')
                    ->width(100)
                    ->height(50)
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->toggleable(isToggledHiddenByDefault: true),
                    // ->stacked(),
                Tables\Columns\TextColumn::make('cities_id')
                    ->label('City name')
                    // ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
               
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),

                Tables\Columns\TextColumn::make('users.name')
                    ->label('Staff')
                    ->numeric()
                    ->sortable(),


                Tables\Columns\IconColumn::make('maintainance_status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('maintainance_start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maintainance_end_date')
                    ->date()
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
            'index' => Pages\ListHalls::route('/'),
            'create' => Pages\CreateHalls::route('/create'),
            'edit' => Pages\EditHalls::route('/{record}/edit'),
        ];
    }
}
