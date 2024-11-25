<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ReviewExporter;
use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_utilizator')->label('Utilizator')
                ->relationship('user', 'name')->
                getOptionLabelFromRecordUsing(fn($record) => $record->name . ' ' . $record->prenume)
                ->preload()->searchable()->required(),
                Select::make('id_produs')->label('Produs')
                ->relationship('product', 'nume')->preload()->searchable()->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable()->toggleable(),
                TextColumn::make('user.name')->label('Utilizator')->formatStateUsing(fn($record) => $record->user->name . ' ' . $record->user->prenume)->sortable()->searchable()->toggleable(),
                TextColumn::make('product.nume')->label('Produs')->sortable()->label('Produs')->searchable()->toggleable(),
                TextColumn::make('rating')->sortable()->searchable()->toggleable(),
                TextColumn::make('titlu')->sortable()->searchable()->toggleable(),
                TextColumn::make('continut')->label('Conținut')->sortable()->searchable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('id_urilizator')->label('Utilizator')
                ->relationship('user', 'name')
                ->preload()
                ->multiple(),
                SelectFilter::make('id_produs')->label('Produs')
                ->relationship('product', 'nume')
                ->preload()
                ->multiple(),
                SelectFilter::make('rating')
                ->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ReviewExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(ReviewExporter::class)
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
