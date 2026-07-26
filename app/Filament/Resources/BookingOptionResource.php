<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingOptionResource\Pages;
use App\Models\BookingOption;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingOptionResource extends Resource
{
    protected static ?string $model = BookingOption::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-list-bullet';

    protected static \UnitEnum|string|null $navigationGroup = 'إدارة الحجوزات';

    protected static ?string $navigationLabel = 'خيارات نموذج الحجز';

    protected static ?string $modelLabel = 'خيار';

    protected static ?string $pluralModelLabel = 'خيارات نموذج الحجز';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('label')
                    ->label('نص الخدمة في القائمة المنسدلة')
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعّل')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('الخدمة')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('مفعّل'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingOptions::route('/'),
            'create' => Pages\CreateBookingOption::route('/create'),
            'edit' => Pages\EditBookingOption::route('/{record}/edit'),
        ];
    }
}
