<?php

namespace App\Filament\Resources\ServiceListItemResource\Pages;

use App\Filament\Resources\ServiceListItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceListItems extends ListRecords
{
    protected static string $resource = ServiceListItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
