<?php

namespace App\Filament\Resources\ServiceListItemResource\Pages;

use App\Filament\Resources\ServiceListItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceListItem extends EditRecord
{
    protected static string $resource = ServiceListItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
