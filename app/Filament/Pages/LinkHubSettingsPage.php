<?php

namespace App\Filament\Pages;

use App\Models\LinkHubSetting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class LinkHubSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-identification';

    protected static \UnitEnum|string|null $navigationGroup = 'صفحة الروابط (Link Hub)';

    protected static ?string $navigationLabel = 'إعدادات صفحة الروابط';

    protected static ?string $title = 'إعدادات صفحة الروابط (links.palderma.com)';

    protected string $view = 'filament.pages.link-hub-settings-page';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $record = LinkHubSetting::first() ?? LinkHubSetting::create([
            'logo' => 'images/branding/logo-white-new.svg',
            'title' => 'مجمع بالديرما الطبي',
            'tagline' => 'عيادة الجلدية والتجميل والليزر — كل ما تحتاجينه في مكان واحد',
        ]);
        $this->data = $record->toArray();
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Forms\Components\FileUpload::make('logo')
                    ->label('الشعار (يُفضّل نسخة بيضاء لأن الخلفية داكنة)')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images/branding'),
                Forms\Components\TextInput::make('title')
                    ->label('اسم المركز الظاهر أعلى الصفحة')
                    ->required(),
                Forms\Components\TextInput::make('tagline')
                    ->label('الوصف المختصر أسفل الاسم')
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

        $record = LinkHubSetting::first() ?? new LinkHubSetting();
        $record->fill($state);
        $record->save();

        Notification::make()
            ->title('تم حفظ إعدادات صفحة الروابط بنجاح')
            ->success()
            ->send();
    }
}
