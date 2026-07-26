<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'شرائح الهيرو';

    protected static ?string $modelLabel = 'شريحة';

    protected static ?string $pluralModelLabel = 'شرائح الهيرو';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('tag')
                    ->label('الوسم العلوي (مثال: فريق طبي متميّز)'),
                Forms\Components\TextInput::make('title')
                    ->label('العنوان الرئيسي')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('subtitle')
                    ->label('الوصف الفرعي')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_desktop')
                    ->label('صورة سطح المكتب (عرضية، الشخص على اليسار ومساحة فارغة يمينًا للنص)')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images')
                    ->required(),
                Forms\Components\FileUpload::make('image_mobile')
                    ->label('صورة الجوال (طولية، الشخص أسفل الصورة ومساحة فارغة أعلاها)')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images')
                    ->required(),
                Forms\Components\TextInput::make('image_alt')
                    ->label('نص بديل للصورة (Alt)'),
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
                Tables\Columns\ImageColumn::make('image_desktop')
                    ->label('المعاينة')
                    ->disk('public_assets'),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->limit(40),
                Tables\Columns\TextColumn::make('tag')
                    ->label('الوسم'),
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
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
