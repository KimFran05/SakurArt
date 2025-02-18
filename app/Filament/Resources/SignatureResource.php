<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SignatureResource\Pages;
use App\Filament\Resources\SignatureResource\RelationManagers;
use App\Models\Signature;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class SignatureResource extends Resource
{
    protected static ?string $model = Signature::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nume')->required(),
                TextInput::make('prenume')->required(),
                TextInput::make('email')->unique(ignoreRecord: true)->required(),
                DatePicker::make('data_nasterii')->required()->label('Data nașterii')
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $nume = $get('nume');
                    $prenume = $get('prenume');
                    $email = $get('email');
                    $data_nasterii = $get('data_nasterii');
                    
                    if($nume && $prenume && $email && $data_nasterii) {
                        $data = $nume . " " . $prenume . " " . $email . " " . $data_nasterii;
                        $signature = hash('sha256', $data);
                        $set('semnatura', $signature);
                    }
                })->live(),
                TextInput::make('semnatura')
                ->unique(ignoreRecord: true)
                ->label('Semnătura electronică')
                ->readOnly()
                ->live(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('nume'),
                TextColumn::make('prenume'),
                TextColumn::make('email'),
                TextColumn::make('data_nasterii')->label('Data nașterii'),
                TextColumn::make('semnatura')->label('Semnătura electronică')->limit(20),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSignatures::route('/'),
            'create' => Pages\CreateSignature::route('/create'),
            'edit' => Pages\EditSignature::route('/{record}/edit'),
        ];
    }
}
