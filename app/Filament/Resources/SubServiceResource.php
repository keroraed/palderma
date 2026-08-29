<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubServiceResource\Pages;
use App\Models\BookingOption;
use App\Models\Service;
use App\Models\SubService;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubServiceResource extends Resource
{
    protected static ?string $model = SubService::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-squares-plus';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'الخدمات الفرعية';

    protected static ?string $modelLabel = 'خدمة فرعية';

    protected static ?string $pluralModelLabel = 'الخدمات الفرعية';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('service_id')
                    ->label('الخدمة الرئيسية التابعة لها')
                    ->relationship('service', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title')
                    ->label('عنوان الخدمة الفرعية')
                    ->placeholder('مثال: فيلر الشفايف وتحديد الكنتور (Russian Lips)')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old) {
                        $currentSlug = (string) $get('slug');
                        if ($currentSlug === '' || $currentSlug === SubService::generateUniqueSlug((string) $old)) {
                            $set('slug', $state ? SubService::generateUniqueSlug($state) : null);
                        }
                    })
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')
                    ->label('الرابط المختصر (Slug)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('badge')
                    ->label('شارة مميزة (Badge)')
                    ->placeholder('مثال: الأكثر طلباً ⭐ أو نتائج فورية')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->label('الوصف الإكلينيكي والتفصيلي')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('duration')
                    ->label('مدة الجلسة')
                    ->placeholder('مثال: 20 - 30 دقيقة'),
                Forms\Components\TextInput::make('target_area')
                    ->label('المنطقة المستهدفة')
                    ->placeholder('مثال: الوجه ومحيط الشفاه'),
                Forms\Components\Repeater::make('features')
                    ->label('مميزات وما تشمله الجلسة (قائمة نقطية)')
                    ->simple(
                        Forms\Components\TextInput::make('feature')->required()
                    )
                    ->addActionLabel('إضافة ميزة')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('aftercare_tips')
                    ->label('نصائح العناية بعد الجلسة (اختياري)')
                    ->placeholder('مثال: تجنب المشروبات الساخنة والضغط على الشفاه لمدة 24 ساعة.')
                    ->rows(2)
                    ->columnSpanFull(),
                Forms\Components\Select::make('booking_option_id')
                    ->label('اربط هذه الخدمة الفرعية بخيار حجز (اختياري)')
                    ->options(BookingOption::where('is_active', true)->orderBy('sort_order')->pluck('label', 'id'))
                    ->searchable()
                    ->native(false)
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service.title')
                    ->label('الخدمة الرئيسية')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('badge')
                    ->label('الشارة')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('duration')
                    ->label('المدة'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('مفعّلة'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('الخدمة الرئيسية')
                    ->relationship('service', 'title'),
            ])
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
            'index' => Pages\ListSubServices::route('/'),
            'create' => Pages\CreateSubService::route('/create'),
            'edit' => Pages\EditSubService::route('/{record}/edit'),
        ];
    }
}
