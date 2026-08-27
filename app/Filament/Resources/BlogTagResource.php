<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogTagResource\Pages;
use App\Models\BlogTag;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogTagResource extends Resource
{
    protected static ?string $model = BlogTag::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-tag';

    protected static \UnitEnum|string|null $navigationGroup = 'المدونة';

    protected static ?string $navigationLabel = 'وسوم المدونة';

    protected static ?string $modelLabel = 'وسم';

    protected static ?string $pluralModelLabel = 'وسوم المدونة';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الوسم')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old) {
                        $currentSlug = (string) $get('slug');
                        if ($currentSlug === '' || $currentSlug === BlogTag::generateUniqueSlug((string) $old)) {
                            $set('slug', $state ? BlogTag::generateUniqueSlug($state) : null);
                        }
                    }),
                Forms\Components\TextInput::make('slug')
                    ->label('الرابط المختصر (Slug)')
                    ->helperText('يُستخدم في رابط الصفحة: /blog/tag/الرابط-المختصر')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->rule('regex:/^[\p{L}\p{N}-]+$/u')
                    ->validationMessages(['regex' => 'الرابط المختصر يجب أن يحتوي على حروف وأرقام وشرطات فقط، بدون مسافات.']),
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
            ])
            ->defaultSort('name', 'asc')
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
            'index' => Pages\ListBlogTags::route('/'),
            'create' => Pages\CreateBlogTag::route('/create'),
            'edit' => Pages\EditBlogTag::route('/{record}/edit'),
        ];
    }
}
