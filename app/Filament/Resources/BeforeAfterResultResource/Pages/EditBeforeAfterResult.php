<?php

namespace App\Filament\Resources\BeforeAfterResultResource\Pages;

use App\Filament\Resources\BeforeAfterResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBeforeAfterResult extends EditRecord
{
    protected static string $resource = BeforeAfterResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
