<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BundleResource\Pages;
use App\Filament\Resources\BundleResource\RelationManagers;
use App\Models\Bundle;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BundleResource extends Resource
{
    protected static ?string $model = Bundle::class;

    protected static ?string $navigationIcon = 'heroicon-o-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nume')->required(),
                TextInput::make('descriere')->required(),
                TextInput::make('discount')
                ->label('Discount (procent)')
                ->live()->required(),
                TextInput::make('pret')->label('Preț')
                    ->readOnly()
                    ->placeholder(function (Get $get, Set $set) {
                        $produse = $get('produse');
                        $discount = $get('discount');
                        $suma = 0;
                        if($produse) {
                            foreach($produse as $produs) {
                                if($produs['cantitate']) {
                                    $suma += $produs['pret'];
                                }
                            } 
                            $suma = $suma - $suma * $discount/100;
                            $suma = number_format($suma, 2);
                            $set('pret', $suma);
                        } else {
                            $set('pret', '0.00'); 
                        }
                    }),
                Section::make('Produse')
                    ->collapsible()
                    ->schema([
                        Select::make('id_categorie')
                            ->label('Categorie')
                            ->relationship('categories', 'nume')
                            ->live()->preload()->searchable()->required(),
                        Repeater::make('produse')
                            ->minItems(3)
                            ->maxItems(3)
                            ->grid(3)
                            ->required()
                            ->schema([
                                Select::make('id_produs')->label('Nume')
                                    ->options(function (Get $get) {
                                        $idCategorie = $get('../../id_categorie');
                                        return $idCategorie 
                                            ? Product::where('id_categorie', (int) $idCategorie)->pluck('nume', 'id') 
                                            : [];
                                    })->disabled(fn (Get $get) => !filled($get('../../id_categorie')))
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $idprodus = $get('id_produs');
                                        $produs = Product::find($idprodus);
                                        if($idprodus && $produs){
                                            $set('pret', $produs->pret); 
                                            $set('name', $produs->nume); 
                                            $set('image', $produs->image); 
                                        } else {
                                            $set('pret', '0.00'); 
                                        }
                                    })->live()->required(),
                                Hidden::make('name'),
                                Hidden::make('image'),
                                TextInput::make('pret')
                                    ->label('Preț')
                                    ->readOnly()
                                    ->default('0.00'),
                                TextInput::make('cantitate')
                                    ->integer()
                                    ->live(onBlur: true)
                                    ->placeholder(function (Set $set) {
                                        $cant = 1;
                                        $set('cantitate', $cant); 
                                    })->readOnly(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable()->toggleable(),
                TextColumn::make('nume')->words(3)->sortable()->searchable()->toggleable(),
                TextColumn::make('categories.nume')->label('Categorie')->sortable()->searchable()->toggleable(),
                TextColumn::make('pret')->label('Preț')->sortable()->searchable()->toggleable(),
                TextColumn::make('descriere')->words(5)->sortable()->searchable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('id_categorie')->label('Categorie')
                ->relationship('categories', 'nume')
                ->preload()
                ->multiple()
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
            'index' => Pages\ListBundles::route('/'),
            'create' => Pages\CreateBundle::route('/create'),
            'edit' => Pages\EditBundle::route('/{record}/edit'),
        ];
    }
}
