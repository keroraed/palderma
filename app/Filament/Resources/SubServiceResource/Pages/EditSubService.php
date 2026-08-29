<?php

namespace App\Filament\Resources\SubServiceResource\Pages;

use App\Filament\Resources\SubServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubService extends EditRecord
{
    protected static string $resource = SubServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
