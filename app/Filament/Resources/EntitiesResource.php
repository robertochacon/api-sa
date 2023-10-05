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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;

class EntitiesResource extends Resource
{
    protected static ?string $model = Entities::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')->required(),
                TextInput::make('phone')->numeric(),
                TextInput::make('email')->required()->email(),
                TextInput::make('tables')->numeric()->required(),
                Textarea::make('description'),
                Textarea::make('address'),
                FileUpload::make('image')
                ->maxSize(1024)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name'),
                TextColumn::make('tables'),
                TextColumn::make('email'),
                TextColumn::make('created_at')
                ->since(),
                CheckboxColumn::make('status')
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
