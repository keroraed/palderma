<?php

namespace App\Filament\Pages;

use App\Models\Doctor;
use App\Models\SpotlightBlock;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class SpotlightBlockPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-star';

    protected static \UnitEnum|string|null $navigationGroup = 'محتوى الموقع';

    protected static ?string $navigationLabel = 'الطبيب المميّز';

    protected static ?string $title = 'قسم الطبيب المميّز (Spotlight)';

    protected string $view = 'filament.pages.spotlight-block-page';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $record = SpotlightBlock::first() ?? SpotlightBlock::create([
            'name' => '', 'specialty' => '', 'bio' => '', 'image' => '',
        ]);
        $this->data = $record->toArray();
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Forms\Components\Select::make('doctor_id')
                    ->label('ربط ببطاقة طبيب موجودة (اختياري)')
                    ->options(Doctor::query()->pluck('name', 'id'))
                    ->searchable()
                    ->helperText('اختياري: للربط فقط، الحقول أدناه هي ما يظهر فعلياً في القسم')
                    ->nullable(),
                Forms\Components\TextInput::make('eyebrow')
                    ->label('النص العلوي (مثال: الطبيب المؤسِّس)'),
                Forms\Components\TextInput::make('name')
                    ->label('اسم الطبيب')
                    ->required(),
                Forms\Components\TextInput::make('specialty')
                    ->label('التخصص')
                    ->required(),
                Forms\Components\Textarea::make('bio')
                    ->label('نبذة تعريفية')
                    ->rows(3)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('صورة الطبيب')
                    ->image()
                    ->disk('public_assets')
                    ->directory('images')
                    ->required(),
                Forms\Components\Repeater::make('stats')
                    ->label('الإحصائيات (مثال: +15 سنة خبرة)')
                    ->schema([
                        Forms\Components\TextInput::make('val')->label('القيمة')->required(),
                        Forms\Components\TextInput::make('lbl')->label('الوصف')->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('qualifications')
                    ->label('المؤهلات والشهادات')
                    ->simple(
                        Forms\Components\TextInput::make('qualification')->required()
                    )
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cta_label')
                    ->label('نص زر الحجز')
                    ->default('احجز استشارة مع الدكتور'),
                Forms\Components\TextInput::make('cta_href')
                    ->label('رابط زر الحجز')
                    ->default('#book'),
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

        $record = SpotlightBlock::first() ?? new SpotlightBlock();
        $record->fill($state);
        $record->save();

        Notification::make()
            ->title('تم حفظ قسم الطبيب المميّز بنجاح')
            ->success()
            ->send();
    }
}
