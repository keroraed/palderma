<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificationResource\Pages;
use App\Models\Certification;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CertificationResource extends Resource
{
    protected static ?string $model = Certification::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shield-check';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'الاعتمادات';

    protected static ?string $modelLabel = 'اعتماد';

    protected static ?string $pluralModelLabel = 'الاعتمادات';

    /**
     * @return array<string, string>
     */
    public static function iconOptions(): array
    {
        return [
            'verified' => 'شارة توثيق (verified)',
            'workspace_premium' => 'وسام تميّز (workspace_premium)',
            'shield' => 'درع حماية (shield)',
            'shield_moon' => 'درع (shield_moon)',
            'health_and_safety' => 'الصحة والسلامة (health_and_safety)',
            'military_tech' => 'وسام عسكري (military_tech)',
            'gpp_good' => 'موافقة معتمدة (gpp_good)',
            'account_balance' => 'جهة حكومية (account_balance)',
            'school' => 'جهة أكاديمية (school)',
            'public' => 'اعتماد دولي (public)',
            'thumb_up' => 'رضا العملاء (thumb_up)',
            'star' => 'تقييم (star)',
            'badge' => 'شارة (badge)',
            'diversity_3' => 'عضوية جمعية (diversity_3)',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\FileUpload::make('image')
                    ->label('صورة الشهادة (اختياري، إن وجدت سيتم عرضها بدل الأيقونة)')
                    ->disk('public_assets')
                    ->directory('images/certificates')
                    ->image()
                    ->imageEditor()
                    ->columnSpanFull(),
                Forms\Components\Select::make('icon')
                    ->label('الأيقونة (تُستخدم فقط إن لم تُرفع صورة)')
                    ->options(self::iconOptions())
                    ->searchable()
                    ->required()
                    ->default('verified')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title')
                    ->label('العنوان (مثال: وزارة الصحة)')
                    ->required(),
                Forms\Components\TextInput::make('subtitle')
                    ->label('الوصف (مثال: ترخيص منشأة صحية)'),
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
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->disk('public_assets'),
                Tables\Columns\TextColumn::make('icon')
                    ->label('الأيقونة')
                    ->badge(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('الوصف'),
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
            'index' => Pages\ListCertifications::route('/'),
            'create' => Pages\CreateCertification::route('/create'),
            'edit' => Pages\EditCertification::route('/{record}/edit'),
        ];
    }
}
