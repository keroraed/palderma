<?php

namespace App\Filament\Pages;

use App\Models\ServiceListItem;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class BulkAddServicesPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'إضافة خدمات دفعة واحدة';

    protected static ?string $title = 'إضافة خدمات دفعة واحدة';

    protected string $view = 'filament.pages.bulk-add-services-page';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(['bulk_text' => '']);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Forms\Components\Textarea::make('bulk_text')
                    ->label('الصق أسماء الخدمات هنا — خدمة واحدة في كل سطر')
                    ->helperText('كل سطر سيُضاف كخدمة منفصلة في قائمة "كل الخدمات" الظاهرة للزوار عند الضغط على زر "عرض جميع الخدمات". الأسطر الفارغة تُتجاهل تلقائياً.')
                    ->rows(20)
                    ->columnSpanFull(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('addAll')
                ->label('إضافة الكل')
                ->icon('heroicon-o-plus-circle')
                ->color('primary')
                ->action('addAll'),
        ];
    }

    public function addAll(): void
    {
        $state = $this->form->getState();
        $lines = preg_split('/\r\n|\r|\n/', (string) ($state['bulk_text'] ?? ''));
        $lines = array_map('trim', $lines);
        $lines = array_filter($lines, fn (string $line) => $line !== '');

        if (empty($lines)) {
            Notification::make()
                ->title('لم يتم إدخال أي خدمات')
                ->warning()
                ->send();
            return;
        }

        $nextSort = (int) (ServiceListItem::max('sort_order') ?? 0) + 1;

        foreach (array_values($lines) as $i => $name) {
            ServiceListItem::create([
                'name' => $name,
                'sort_order' => $nextSort + $i,
                'is_active' => true,
            ]);
        }

        $this->form->fill(['bulk_text' => '']);

        Notification::make()
            ->title('تمت إضافة ' . count($lines) . ' خدمة بنجاح')
            ->success()
            ->send();
    }
}
