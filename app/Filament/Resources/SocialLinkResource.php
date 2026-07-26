<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialLinkResource\Pages;
use App\Models\SocialLink;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialLinkResource extends Resource
{
    protected static ?string $model = SocialLink::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-share';

    protected static \UnitEnum|string|null $navigationGroup = 'القوائم والروابط';

    protected static ?string $navigationLabel = 'روابط التواصل الاجتماعي';

    protected static ?string $modelLabel = 'رابط تواصل';

    protected static ?string $pluralModelLabel = 'روابط التواصل الاجتماعي';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('platform')
                    ->label('المنصّة')
                    ->options([
                        'instagram' => 'انستغرام',
                        'x' => 'إكس (تويتر)',
                        'youtube' => 'يوتيوب',
                        'tiktok' => 'تيك توك',
                        'snapchat' => 'سناب شات',
                        'whatsapp' => 'واتساب',
                        'facebook' => 'فيسبوك',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->label('الرابط الكامل')
                    ->url()
                    ->required(),
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
                Tables\Columns\TextColumn::make('platform')
                    ->label('المنصّة')
                    ->badge(),
                Tables\Columns\TextColumn::make('url')
                    ->label('الرابط')
                    ->url(fn (SocialLink $record) => $record->url)
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListSocialLinks::route('/'),
            'create' => Pages\CreateSocialLink::route('/create'),
            'edit' => Pages\EditSocialLink::route('/{record}/edit'),
        ];
    }
}
