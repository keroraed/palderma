<?php

namespace App\Filament\Pages;

use App\Models\AboutBlock;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class AboutBlockPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-information-circle';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'قسم من نحن';

    protected static ?string $title = 'محتوى قسم "من نحن"';

    protected string $view = 'filament.pages.about-block-page';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $record = AboutBlock::first() ?? AboutBlock::create(['image' => '', 'cards' => []]);
        $this->data = $record->toArray();
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Forms\Components\FileUpload::make('image')
                    ->label('صورة القسم (عمودية تقريباً 4:5)')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images')
                    ->required(),
                Forms\Components\TextInput::make('badge_title')
                    ->label('عنوان الشارة العائمة (مثال: اعتماد رسمي)'),
                Forms\Components\TextInput::make('badge_text')
                    ->label('نص الشارة العائمة'),
                Forms\Components\Repeater::make('cards')
                    ->label('البطاقتان (رؤيتنا / رسالتنا)')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان البطاقة')
                            ->required(),
                        Forms\Components\Textarea::make('body')
                            ->label('نص البطاقة')
                            ->rows(2)
                            ->required(),
                    ])
                    ->columns(1)
                    ->maxItems(2)
                    ->columnSpanFull(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('حفظ التغييرات')
                ->icon('heroicon-o-check')
                ->action('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $record = AboutBlock::first() ?? new AboutBlock();
        $record->fill($state);
        $record->save();

        Notification::make()
            ->title('تم حفظ قسم "من نحن" بنجاح')
            ->success()
            ->send();
    }
}
