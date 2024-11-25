<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nume')->required(),
                TextInput::make('producator')->required(),
                TextInput::make('pret')->required(),
                TextInput::make('descriere')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nume')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable()->toggleable(),
                TextColumn::make('nume')->words(3)->sortable()->searchable()->toggleable(),
                TextColumn::make('producator')->sortable()->label('Producător')->searchable()->toggleable(),
                TextColumn::make('pret')->label('Preț')->sortable()->searchable()->toggleable(),
                TextColumn::make('descriere')->words(5)->sortable()->searchable()->toggleable(),
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
