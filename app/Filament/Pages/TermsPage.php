<?php

namespace App\Filament\Pages;

use App\Models\LegalPage;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class TermsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static \UnitEnum|string|null $navigationGroup = 'الصفحات القانونية';

    protected static ?string $navigationLabel = 'الشروط والأحكام';

    protected static ?string $title = 'الشروط والأحكام';

    protected string $view = 'filament.pages.legal-page-form';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $record = LegalPage::firstOrCreate(['key' => 'terms'], ['title' => 'الشروط والأحكام']);
        $this->data = $record->toArray();
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان الصفحة')
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->label('محتوى الشروط والأحكام')
                    ->required()
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

        $record = LegalPage::where('key', 'terms')->first() ?? new LegalPage(['key' => 'terms']);
        $record->fill($state);
        $record->save();

        Notification::make()
            ->title('تم حفظ الشروط والأحكام بنجاح')
            ->success()
            ->send();
    }
}
