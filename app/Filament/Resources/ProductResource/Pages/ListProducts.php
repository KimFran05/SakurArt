<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make() 
                ->uniqueField('nume')
                ->fields([
                    ImportField::make('nume')
                        ->required(),
                    ImportField::make('producator')
                        ->label('Producător')
                        ->required(),
                    ImportField::make('id_categorie')
                        ->label('Categorie')
                        ->required(),
                    ImportField::make('pret')
                        ->label('Preț')
                        ->required(),
                    ImportField::make('descriere'),
                ]),
        ];
    }
}
