<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $modelLabel = 'طبيب';

    protected static ?string $pluralModelLabel = 'الأطباء';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الطبيب')
                    ->required(),
                Forms\Components\TextInput::make('specialty')
                    ->label('التخصص')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label('صورة الطبيب')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images')
                    ->required(),
                Forms\Components\Textarea::make('bio')
                    ->label('نبذة عن الطبيب')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('experience_display')
                    ->label('نص سنوات الخبرة (مثال: +16)'),
                Forms\Components\TextInput::make('patients_display')
                    ->label('نص الحالات الناجحة (مثال: +12k)'),
                Forms\Components\Repeater::make('qualifications')
                    ->label('المؤهلات والشهادات')
                    ->simple(
                        Forms\Components\TextInput::make('qualification')->required()
                    )
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعل في الموقع')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('specialty')
                    ->label('التخصص')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('مفعل'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
