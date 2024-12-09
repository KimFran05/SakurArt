<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ProductExporter;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\ReviewsRelationManager;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nume')->required(),
                TextInput::make('producator')->required(),
                TextInput::make('pret')->required(),
                Select::make('id_categorie')->label('Categorie')
                ->relationship('categories', 'nume')
                ->preload()->searchable()->required(),
                TextInput::make('stoc')->numeric()->minValue(0)->required(),
                TextInput::make('descriere')->required(),
                FileUpload::make('image')->label('Imagine produs')->disk('public')->directory('produse'),
                FileUpload::make('file')->label('PDF')->disk('public')->directory('produse')->acceptedFileTypes(['application/pdf']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable()->toggleable(),
                ImageColumn::make('image')->label('Imagine produs'),
                TextColumn::make('nume')->words(3)->sortable()->searchable()->toggleable(),
                TextColumn::make('producator')->sortable()->label('Producător')->searchable()->toggleable(),
                TextColumn::make('categories.nume')->label('Categorie')->sortable()->searchable()->toggleable(),
                TextColumn::make('pret')->label('Preț')->sortable()->searchable()->toggleable(),
                TextColumn::make('stoc')->sortable(),
                TextColumn::make('descriere')->words(5)->sortable()->searchable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('id_categorie')->label('Categorie')
                ->relationship('categories', 'nume')
                ->preload()
                ->multiple()
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->label('PDF')
                    ->action(function ($record) {
                        $filePath = $record->file;
                        if (empty($filePath)) {
                            return;
                        }

                        if (Storage::disk('public')->exists($filePath)) {
                            return response()->download(storage_path("app/public/{$filePath}"));
                        }
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ProductExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(ProductExporter::class)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ReviewsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
