<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cube';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'الباقات';

    protected static ?string $modelLabel = 'باقة';

    protected static ?string $pluralModelLabel = 'الباقات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الباقة')
                    ->required(),
                Forms\Components\TextInput::make('tagline')
                    ->label('الوصف المختصر'),
                Forms\Components\TextInput::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('currency')
                    ->label('العملة')
                    ->default('ريال')
                    ->required(),
                Forms\Components\Toggle::make('is_featured')
                    ->label('الباقة المميّزة (الأكثر طلباً)')
                    ->live()
                    ->default(false),
                Forms\Components\TextInput::make('featured_badge')
                    ->label('نص شارة التمييز (مثال: الأكثر طلباً)')
                    ->visible(fn (Get $get) => $get('is_featured')),
                Forms\Components\Repeater::make('features')
                    ->label('مزايا الباقة')
                    ->schema([
                        Forms\Components\TextInput::make('text')
                            ->label('نص الميزة')
                            ->required()
                            ->columnSpan(3),
                        Forms\Components\Toggle::make('is_included')
                            ->label('متضمّنة')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->reorderable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cta_label')
                    ->label('نص زر الحجز')
                    ->default('احجز هذه الباقة'),
                Forms\Components\TextInput::make('cta_href')
                    ->label('رابط زر الحجز')
                    ->default('#book'),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->formatStateUsing(fn ($state, Package $record) => number_format((float) $state, 0).' '.$record->currency),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميّزة')
                    ->boolean(),
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
