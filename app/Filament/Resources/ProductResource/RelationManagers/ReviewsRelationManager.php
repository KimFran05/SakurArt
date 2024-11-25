<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_utilizator')->label('Utilizator')
                ->relationship('user', 'name')->
                getOptionLabelFromRecordUsing(fn($record) => $record->name . ' ' . $record->prenume)
                ->preload()->searchable()->required(),
                Select::make('rating')
                ->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])
                ->required(),
                TextInput::make('titlu')->required(),
                TextInput::make('continut')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('titlu')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable()->toggleable(),
                TextColumn::make('user.name')->label('Utilizator')->formatStateUsing(fn($record) => $record->user->name . ' ' . $record->user->prenume)->sortable()->searchable()->toggleable(),
                TextColumn::make('rating')->sortable()->searchable()->toggleable(),
                TextColumn::make('titlu')->sortable()->searchable()->toggleable(),
                TextColumn::make('continut')->label('Conținut')->sortable()->searchable()->toggleable(),
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
