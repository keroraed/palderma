<?php

namespace App\Filament\Resources\BookingOptionResource\Pages;

use App\Filament\Resources\BookingOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingOption extends EditRecord
{
    protected static string $resource = BookingOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
