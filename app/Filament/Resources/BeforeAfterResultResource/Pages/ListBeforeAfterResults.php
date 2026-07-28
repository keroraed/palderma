<?php

namespace App\Filament\Resources\BeforeAfterResultResource\Pages;

use App\Filament\Resources\BeforeAfterResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBeforeAfterResults extends ListRecords
{
    protected static string $resource = BeforeAfterResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
