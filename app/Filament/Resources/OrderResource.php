<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
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
                        $suma = 0;
                        if($produse) {
                        foreach($produse as $produs) {
                                if($produs['cantitate']) {
                                    $suma += $produs['pret'] * $produs['cantitate'];
                                    $suma = number_format($suma, 2);
                                    $set('subtotal', $suma);
                                }
                            } 
                        } else {
                            $set('subtotal', '0.00'); 
                        }
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
                    ->columnSpanFull()
                    ->columns(3)
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
                            } else {
                                $set('pret', '0.00'); 
                            }
                        })->live(),
                        Hidden::make('name'),
                        Hidden::make('image'),
                        TextInput::make('pret')->label('Preț')->readOnly()->default('0.00'),
                        TextInput::make('cantitate')->integer()->minValue(1)->default(1)
                        ->live(onBlur: false),
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
