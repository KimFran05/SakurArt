<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Bundle;
use App\Models\Order;
use App\Models\Product;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Group;
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
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalii livrare')
                ->columnSpan(1)
                ->columns(3)
                ->schema([
                    Select::make('id_utilizator')->label('Utilizator')
                    ->relationship('user', 'name')->
                    getOptionLabelFromRecordUsing(fn($record) => $record->name . ' ' . $record->prenume)
                    ->preload()->searchable()->required(),
                    TextInput::make('nume')->required(),
                    TextInput::make('prenume')->required(),
                    TextInput::make('numartelefon')->label('Număr telefon')->required(),
                    TextInput::make('adresa')->label('Adresă')->required(),
                    TextInput::make('judet')->label('Județ')->required(),
                    TextInput::make('localitate')->required(),
                ]),
                Group::make()
                ->schema([
                    TextInput::make('subtotal')->label('Cost produse')->readOnly()
                    ->live(onBlur: true)
                    ->placeholder(function (Get $get, Set $set) {
                        $produse = $get('produse');
                        $grupbundle = $get('bundle');
                        $gruppers = $get('personalizate');
                        $suma = 0;
                        $sumaprod = 0;
                        $sumabundle = 0;
                        $sumapers = 0;
                        if($produse) {
                            foreach($produse as $produs) {
                                if($produs['cantitate']) {
                                    $sumaprod += $produs['pret'] * $produs['cantitate'];
                                }
                            } 
                        }
                        if ($grupbundle) {
                            foreach ($grupbundle as $grup) {
                                if (isset($grup['bundles'])) {
                                    foreach ($grup['bundles'] as $bundle) {
                                        if (isset($bundle['pret'], $bundle['cantitate'])) {
                                            $sumabundle += $bundle['pret'] * $bundle['cantitate'];
                                        }
                                    }
                                }
                            }
                        }
                        if ($gruppers) {
                            foreach ($gruppers as $pers) {
                                if (isset($pers['totalbundle'])) {
                                    $sumapers += $pers['totalbundle'];
                                }
                            }
                        }
                        $suma = $sumaprod + $sumabundle + $sumapers;
                        $suma = number_format($suma, 2);
                        $set('subtotal', $suma);
                    }),
                    TextInput::make('costlivr')->label('Cost livrare')
                    ->live(onBlur: true)
                    ->placeholder(function (Set $set) {
                        $suma = 10;
                        $suma = number_format($suma, 2);
                        $set('costlivr', $suma); 
                    })->readOnly(),
                    TextInput::make('total')->readOnly()
                    ->live(onBlur: true)
                    ->placeholder(function (Get $get, Set $set) {
                        $subtotal = $get('subtotal');
                        $total = 0;
                        if($subtotal != 0) {
                            $total = $subtotal + 10;
                            $total = number_format($total, 2);
                            $set('total', $total);
                        } else {
                            $set('total', '0.00'); 
                        }
                    }),
                ]),
                Section::make('Produse')->collapsible()
                ->schema([
                    Repeater::make('produse')
                    ->defaultItems(0)
                    ->grid(3)
                    ->schema([
                        Select::make('id_produs')->label('Nume')
                        ->relationship('product', 'nume')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $idprodus = $get('id_produs');
                            $produs = Product::find($idprodus);
                            if($idprodus && $produs){
                                $set('pret', $produs->pret); 
                                $set('name', $produs->nume); 
                                $set('image', $produs->image); 
                            }
                        })->live(),
                        Hidden::make('name'),
                        Hidden::make('image'),
                        TextInput::make('pret')->label('Preț')->readOnly()->default('0.00'),
                        TextInput::make('cantitate')->integer()->minValue(1)->default(1)
                        ->live(onBlur: false),
                    ]),
                ]),
                Section::make('Bundles')
                    ->collapsible()
                    ->schema([
                        Repeater::make('bundle')
                        ->defaultItems(0)
                            ->grid(2)
                            ->schema([
                                Select::make('id_categorie')->label('Categorie')
                                    ->relationship('categories', 'nume')
                                    ->live()->preload()->searchable(),
                                Repeater::make('bundles')
                                    ->hiddenLabel()
                                    ->schema([
                                        Select::make('id')->label('Nume')
                                            ->options(function (Get $get) {
                                                $idCategorie = $get('../../id_categorie');
                                                return $idCategorie 
                                                    ? Bundle::where('id_categorie', (int) $idCategorie)->pluck('nume', 'id') 
                                                    : [];
                                            })->disabled(fn (Get $get) => !filled($get('../../id_categorie')))
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Set $set, Get $get) {
                                                $id = $get('id');
                                                $bundle = Bundle::find($id);
                                                if($id && $bundle){
                                                    $set('name', $bundle->nume); 
                                                    $set('pret', $bundle->pret); 
                                                } else {
                                                    $set('pret', '0.00'); 
                                                }
                                            })->live(),
                                        Hidden::make('name'),
                                        TextInput::make('pret')
                                            ->label('Preț')
                                            ->readOnly()
                                            ->default('0.00'),
                                        TextInput::make('cantitate')
                                            ->integer()
                                            ->live(onBlur: false)
                                            ->minValue(1)
                                            ->default(1),                
                                    ])
                            ])
                    ]),
                Section::make('Personalizate')
                    ->collapsible()
                    ->schema([
                        Repeater::make('personalizate')
                            ->label('Bundle')
                            ->defaultItems(0)
                            ->live()
                            ->schema([
                                Select::make('id_categorie')->label('Categorie')
                                    ->relationship('categories', 'nume')
                                    ->live()->preload()->searchable(),
                                TextInput::make('discount')
                                ->live()
                                ->default('20%')
                                ->readOnly(),
                                TextInput::make('totalbundle')->label('Total')->readOnly()
                                ->live()
                                ->placeholder(function (Get $get, Set $set) {
                                    $produse = $get('produsepersonalizate');
                                    $suma = 0;
                                    if($produse) {
                                    foreach($produse as $produs) {
                                            if($produs['cantitate']) {
                                                $suma += $produs['pret'];
                                            }
                                        } 
                                        $suma = $suma - $suma * 20/100;
                                        $suma = number_format($suma, 2);
                                        $set('totalbundle', $suma);
                                    } else {
                                        $set('totalbundle', '0.00'); 
                                    }
                                })->live(),
                                Section::make()
                                ->schema([
                                    Repeater::make('produsepersonalizate')
                                    ->label('Produse')
                                    ->live()
                                    ->grid(3)
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
                                            })->live(),
                                        Hidden::make('name'),
                                        Hidden::make('image'),
                                        TextInput::make('pret')
                                            ->label('Preț')
                                            ->readOnly()
                                            ->default('0.00')
                                            ->live(),
                                        TextInput::make('cantitate')
                                            ->integer()
                                            ->default(1)
                                            ->readOnly(),
                                    ])->collapsible()->minItems(3)->maxItems(3)
                                ])
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable()->toggleable(),
                TextColumn::make('user.name')->label('Utilizator')->formatStateUsing(fn($record) => $record->user->name . ' ' . $record->user->prenume)->sortable()->searchable()->toggleable(),
                TextColumn::make('nume'),
                TextColumn::make('prenume'),
                TextColumn::make('numartelefon')->label('Număr de telefon'),
                TextColumn::make('adresa')->label('Adresă'),
                TextColumn::make('judet')->label('Județ'),
                TextColumn::make('localitate'),
                TextColumn::make('total'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Model $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.pdf', ['record' => $record])
                            )->output();
                        }, $record->id . '.pdf', ['Content-Type' => 'application/pdf']);
                    }),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
