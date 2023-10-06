<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EntitiesResource\Pages;
use App\Filament\Resources\EntitiesResource\RelationManagers;
use App\Models\Entities;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EntitiesResource extends Resource
{
    protected static ?string $model = Entities::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('id_plan')->relationship('plans', 'name')->searchable(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('phone')->numeric(),
                Forms\Components\TextInput::make('email')->required()->email(),
                Forms\Components\TextInput::make('tables')->numeric()->required(),
                Forms\Components\FileUpload::make('image')
                ->maxSize(1024),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Textarea::make('address'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\TextColumn::make('plans.name'),
                Tables\Columns\TextColumn::make('tables'),
                Tables\Columns\TextColumn::make('email')
                ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->since(),
                Tables\Columns\ToggleColumn::make('status')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\CategoriesRelationManager::class,
            RelationManagers\ProductsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntities::route('/'),
            'create' => Pages\CreateEntities::route('/create'),
            'edit' => Pages\EditEntities::route('/{record}/edit'),
        ];
    }    
}
