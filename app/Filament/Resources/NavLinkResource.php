<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavLinkResource\Pages;
use App\Models\NavLink;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NavLinkResource extends Resource
{
    protected static ?string $model = NavLink::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-link';

    protected static \UnitEnum|string|null $navigationGroup = 'القوائم والروابط';

    protected static ?string $navigationLabel = 'روابط القائمة';

    protected static ?string $modelLabel = 'رابط';

    protected static ?string $pluralModelLabel = 'روابط القائمة';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('label')
                    ->label('النص الظاهر')
                    ->required(),
                Forms\Components\TextInput::make('href')
                    ->label('الرابط (مثال: #about)')
                    ->required(),
                Forms\Components\Toggle::make('show_in_header')
                    ->label('يظهر في القائمة العلوية (Header)')
                    ->default(true),
                Forms\Components\Toggle::make('show_in_footer')
                    ->label('يظهر في تذييل الصفحة (Footer)')
                    ->default(true),
                Forms\Components\Toggle::make('is_cta')
                    ->label('زر بارز (مثل: احجز الآن)')
                    ->default(false),
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
                    ->label('النص')
                    ->searchable(),
                Tables\Columns\TextColumn::make('href')
                    ->label('الرابط'),
                Tables\Columns\IconColumn::make('show_in_header')
                    ->label('القائمة العلوية')
                    ->boolean(),
                Tables\Columns\IconColumn::make('show_in_footer')
                    ->label('التذييل')
                    ->boolean(),
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
            'index' => Pages\ListNavLinks::route('/'),
            'create' => Pages\CreateNavLink::route('/create'),
            'edit' => Pages\EditNavLink::route('/{record}/edit'),
        ];
    }
}
