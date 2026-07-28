<?php

namespace App\Filament\Resources\LinkHubItemResource\Pages;

use App\Filament\Resources\LinkHubItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinkHubItem extends EditRecord
{
    protected static string $resource = LinkHubItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
