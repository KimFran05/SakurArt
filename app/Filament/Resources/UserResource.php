<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\ReviewsRelationManager;
use App\Models\User;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nume')->rules(['min:3', 'max:20'])->required(),
                TextInput::make('prenume')->rules(['min:3', 'max:20'])->nullable(),
                TextInput::make('email')->unique(ignoreRecord: true)->required(),
                TextInput::make('password')->password()->rule('min:8')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                FileUpload::make('image')->label('Imagine profil')->disk('public')->directory('profil'),
                Select::make('functie')
                ->options([
                    'ADMIN' => 'ADMIN',
                    'USER' => 'USER'
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable()->toggleable(),
                ImageColumn::make('image')->label('Imagine profil'),
                TextColumn::make('name')->label('Nume')->sortable()->searchable()->toggleable(),
                TextColumn::make('prenume')->sortable()->searchable()->toggleable(),
                TextColumn::make('email')->sortable()->searchable()->toggleable(),
                TextColumn::make('functie')->label('Funcție')->sortable()->searchable()->badge()->color(function(string $state): string{
                    return match($state){
                        'USER' => 'info',
                        'ADMIN' => 'danger'
                    };
                })->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('functie')
                ->label('Funcție')
                ->placeholder('-')
                ->trueLabel('ADMIN')
                ->falseLabel('USER')
                ->queries(
                    true: fn (Builder $query) => $query->where('functie', 'like', 'ADMIN'),
                    false: fn (Builder $query) => $query->where('functie', 'like', 'USER'),
                    blank: fn (Builder $query) => $query,
                ),
                TernaryFilter::make('image')
                ->label('Imagine profil')
                ->placeholder('-')
                ->trueLabel('Cu imagine')
                ->falseLabel('Fără imagine')
                ->queries(
                    true: fn (Builder $query) => $query->whereNotNull('image')->where('image', '!=', ''),
                    false: fn (Builder $query) => $query->whereNull('image')->orWhere('image', '=', ''),
                    blank: fn (Builder $query) => $query,
                )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(UserExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(UserExporter::class)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
