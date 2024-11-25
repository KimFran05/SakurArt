<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Widgets\UsersWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make() 
                ->uniqueField('email')
                ->fields([
                    ImportField::make('name')
                        ->label('Nume')
                        ->required(),
                    ImportField::make('prenume'),
                    ImportField::make('email')
                        ->required(),
                    ImportField::make('functie')
                        ->label('Funcție')
                        ->required(),
                ]),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UsersWidget::class
        ];
    }
}
