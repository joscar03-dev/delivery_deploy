<?php

namespace App\Filament\Resources\NegocioResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductosRelationManager extends RelationManager
{
    protected static string $relationship = 'productos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->label('Nombre del Producto'),
                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción'),
                Forms\Components\TextInput::make('precio')
                    ->numeric()
                    ->label('Precio'),
                Forms\Components\FileUpload::make('imagen')
                    ->label('Imagen del Producto')
                    ->directory('productos'),
                Forms\Components\Select::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre') // Se asume que el modelo Producto tiene relación `categoria()`
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('nombre')->sortable()->searchable(),
                TextColumn::make('precio')->sortable(),
                ImageColumn::make('imagen'),
                TextColumn::make('categoria.nombre')->label('Categoría'),
                TextColumn::make('created_at')->label('Fecha de creación')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
