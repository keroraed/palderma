<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCategoryResource\Pages;
use App\Models\BlogCategory;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-folder';

    protected static \UnitEnum|string|null $navigationGroup = 'المدونة';

    protected static ?string $navigationLabel = 'تصنيفات المدونة';

    protected static ?string $modelLabel = 'تصنيف';

    protected static ?string $pluralModelLabel = 'تصنيفات المدونة';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('اسم التصنيف')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old) {
                        // Only auto-fill while the slug still matches what we'd have
                        // generated ourselves — an admin's manual edit is never overwritten.
                        $currentSlug = (string) $get('slug');
                        if ($currentSlug === '' || $currentSlug === BlogCategory::generateUniqueSlug((string) $old)) {
                            $set('slug', $state ? BlogCategory::generateUniqueSlug($state) : null);
                        }
                    }),
                Forms\Components\TextInput::make('slug')
                    ->label('الرابط المختصر (Slug)')
                    ->helperText('يُستخدم في رابط الصفحة: /blog/category/الرابط-المختصر')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->rule('regex:/^[\p{L}\p{N}-]+$/u')
                    ->validationMessages(['regex' => 'الرابط المختصر يجب أن يحتوي على حروف وأرقام وشرطات فقط، بدون مسافات.']),
                Forms\Components\Textarea::make('description')
                    ->label('وصف مختصر (اختياري)')
                    ->rows(2)
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('الرابط المختصر')
                    ->fontFamily('mono')
                    ->copyable(),
                Tables\Columns\TextColumn::make('posts_count')
                    ->label('عدد المقالات')
                    ->counts('posts'),
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
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
