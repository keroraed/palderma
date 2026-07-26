<?php

namespace App\Filament\Resources\BookingOptionResource\Pages;

use App\Filament\Resources\BookingOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingOptions extends ListRecords
{
    protected static string $resource = BookingOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
