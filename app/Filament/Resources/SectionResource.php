<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Models\Section;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'أقسام الصفحة';

    protected static ?string $modelLabel = 'قسم';

    protected static ?string $pluralModelLabel = 'أقسام الصفحة';

    protected static ?int $navigationSort = -10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('key')
                    ->label('المعرّف (لا يُعدَّل)')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('eyebrow')
                    ->label('النص العلوي الصغير (Eyebrow)'),
                Forms\Components\TextInput::make('title')
                    ->label('العنوان الرئيسي')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('الوصف / الفقرة')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_visible')
                    ->label('ظاهر في الموقع')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('المعرّف')
                    ->badge(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->limit(50),
                Tables\Columns\TextColumn::make('eyebrow')
                    ->label('النص العلوي'),
                Tables\Columns\ToggleColumn::make('is_visible')
                    ->label('ظاهر'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
