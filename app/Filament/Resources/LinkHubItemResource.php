<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkHubItemResource\Pages;
use App\Models\LinkHubItem;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LinkHubItemResource extends Resource
{
    protected static ?string $model = LinkHubItem::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static \UnitEnum|string|null $navigationGroup = 'صفحة الروابط (Link Hub)';

    protected static ?string $navigationLabel = 'أزرار صفحة الروابط';

    protected static ?string $modelLabel = 'زر';

    protected static ?string $pluralModelLabel = 'أزرار صفحة الروابط';

    /**
     * @return array<string, string>
     */
    public static function iconOptions(): array
    {
        return [
            'storefront' => 'متجر (storefront)',
            'calendar_month' => 'حجز موعد (calendar_month)',
            'location_on' => 'الموقع على الخريطة (location_on)',
            'call' => 'اتصال (call)',
            'mail' => 'بريد إلكتروني (mail)',
            'star' => 'مميز (star)',
            'link' => 'رابط عام (link)',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('label')
                    ->label('نص الزر (مثال: زوروا متجرنا الإلكتروني)')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url')
                    ->label('الرابط الكامل')
                    ->url()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('icon')
                    ->label('الأيقونة')
                    ->options(self::iconOptions())
                    ->searchable()
                    ->required()
                    ->default('link'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعّل في العرض')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('الأيقونة')
                    ->badge(),
                Tables\Columns\TextColumn::make('label')
                    ->label('النص')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('الرابط')
                    ->limit(40),
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
            'index' => Pages\ListLinkHubItems::route('/'),
            'create' => Pages\CreateLinkHubItem::route('/create'),
            'edit' => Pages\EditLinkHubItem::route('/{record}/edit'),
        ];
    }
}
