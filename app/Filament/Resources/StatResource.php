<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatResource\Pages;
use App\Models\Stat;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'شريط الإحصائيات';

    protected static ?string $modelLabel = 'إحصائية';

    protected static ?string $pluralModelLabel = 'شريط الإحصائيات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('value')
                    ->label('القيمة (مثال: 15 أو 4.9)')
                    ->required(),
                Forms\Components\TextInput::make('prefix')
                    ->label('بادئة (مثال: +)'),
                Forms\Components\TextInput::make('suffix')
                    ->label('لاحقة (مثال: k)'),
                Forms\Components\TextInput::make('label')
                    ->label('الوصف (مثال: عاماً من الخبرة)')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعّلة في العرض')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('القيمة'),
                Tables\Columns\TextColumn::make('prefix')
                    ->label('بادئة'),
                Tables\Columns\TextColumn::make('suffix')
                    ->label('لاحقة'),
                Tables\Columns\TextColumn::make('label')
                    ->label('الوصف'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('مفعّلة'),
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
            'index' => Pages\ListStats::route('/'),
            'create' => Pages\CreateStat::route('/create'),
            'edit' => Pages\EditStat::route('/{record}/edit'),
        ];
    }
}
