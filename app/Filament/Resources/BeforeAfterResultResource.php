<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeforeAfterResultResource\Pages;
use App\Models\BeforeAfterResult;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BeforeAfterResultResource extends Resource
{
    protected static ?string $model = BeforeAfterResult::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'نتائج قبل وبعد';

    protected static ?string $modelLabel = 'نتيجة';

    protected static ?string $pluralModelLabel = 'نتائج قبل وبعد';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('label')
                    ->label('وصف مختصر (اختياري، للتنظيم الداخلي فقط)')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('before_image')
                    ->label('صورة قبل')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images')
                    ->required(),
                Forms\Components\FileUpload::make('after_image')
                    ->label('صورة بعد')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images')
                    ->required(),
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
                Tables\Columns\ImageColumn::make('before_image')
                    ->label('قبل')
                    ->disk('public_assets'),
                Tables\Columns\ImageColumn::make('after_image')
                    ->label('بعد')
                    ->disk('public_assets'),
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
            'index' => Pages\ListBeforeAfterResults::route('/'),
            'create' => Pages\CreateBeforeAfterResult::route('/create'),
            'edit' => Pages\EditBeforeAfterResult::route('/{record}/edit'),
        ];
    }
}
