<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'الأسئلة الشائعة';

    protected static ?string $modelLabel = 'سؤال شائع';

    protected static ?string $pluralModelLabel = 'الأسئلة الشائعة';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('question')
                    ->label('السؤال')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer')
                    ->label('الإجابة')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('question')
                    ->label('السؤال')
                    ->searchable()
                    ->limit(60),
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
