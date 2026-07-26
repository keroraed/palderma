<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-sparkles';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'الخدمات';

    protected static ?string $modelLabel = 'خدمة';

    protected static ?string $pluralModelLabel = 'الخدمات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان الخدمة')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('الوصف')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\Radio::make('icon_type')
                    ->label('نوع الأيقونة')
                    ->options([
                        'material' => 'أيقونة جاهزة (Material Symbols)',
                        'svg' => 'رمز SVG مخصّص',
                    ])
                    ->default('material')
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('icon_value')
                    ->label('اسم الأيقونة (مثال: medical_services)')
                    ->helperText('ابحث عن الاسم في Google Material Symbols')
                    ->visible(fn (Get $get) => $get('icon_type') === 'material')
                    ->required(fn (Get $get) => $get('icon_type') === 'material'),
                Forms\Components\Textarea::make('icon_value')
                    ->label('كود SVG الكامل')
                    ->rows(4)
                    ->visible(fn (Get $get) => $get('icon_type') === 'svg')
                    ->required(fn (Get $get) => $get('icon_type') === 'svg')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon_type')
                    ->label('نوع الأيقونة')
                    ->badge(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
