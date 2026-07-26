<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class SiteSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static \UnitEnum|string|null $navigationGroup = 'الإعدادات والربط';

    protected static ?string $navigationLabel = 'إعدادات الموقع العامة';

    protected static ?string $title = 'إعدادات الموقع العامة';

    protected string $view = 'filament.pages.site-settings-page';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $record = SiteSetting::first() ?? SiteSetting::create([]);
        $this->data = $record->toArray();
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('settings')
                    ->tabs([
                        Tabs\Tab::make('التواصل والتذييل')
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('رقم الهاتف'),
                                Forms\Components\TextInput::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->email(),
                                Forms\Components\TextInput::make('address')
                                    ->label('العنوان'),
                                Forms\Components\TextInput::make('working_hours')
                                    ->label('أوقات العمل'),
                                Forms\Components\TextInput::make('copyright')
                                    ->label('نص حقوق النشر (أسفل التذييل)')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('privacy_policy_url')
                                    ->label('رابط سياسة الخصوصية'),
                                Forms\Components\TextInput::make('terms_url')
                                    ->label('رابط الشروط والأحكام'),
                            ])->columns(2),
                        Tabs\Tab::make('الشعارات')
                            ->schema([
                                Forms\Components\FileUpload::make('logo_primary')
                                    ->label('الشعار الملوّن (للخلفيات الفاتحة)')
                                    ->image()
                                    ->disk('public_assets')
                                    ->directory('images'),
                                Forms\Components\FileUpload::make('logo_white')
                                    ->label('الشعار الأبيض (للخلفيات الداكنة، التذييل)')
                                    ->image()
                                    ->disk('public_assets')
                                    ->directory('images'),
                                Forms\Components\FileUpload::make('favicon')
                                    ->label('أيقونة المتصفح (Favicon)')
                                    ->image()
                                    ->disk('public_assets')
                                    ->directory('images'),
                            ])->columns(2),
                        Tabs\Tab::make('السيو (SEO)')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('عنوان الصفحة (Title Tag)')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_description')
                                    ->label('وصف الصفحة (Meta Description)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('seo_og_image')
                                    ->label('صورة المشاركة (Open Graph)')
                                    ->image()
                                    ->disk('public_assets')
                                    ->directory('images'),
                                Forms\Components\TextInput::make('ga_tracking_id')
                                    ->label('معرّف Google Analytics'),
                            ]),
                        Tabs\Tab::make('نموذج الحجز')
                            ->schema([
                                Forms\Components\Textarea::make('booking_privacy_note')
                                    ->label('ملاحظة الخصوصية أسفل نموذج الحجز')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('booking_success_message')
                                    ->label('رسالة النجاح بعد إرسال الحجز')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ])
            ->statePath('data');
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

        $record = SiteSetting::first() ?? new SiteSetting();
        $record->fill($state);
        $record->save();

        Notification::make()
            ->title('تم حفظ إعدادات الموقع بنجاح')
            ->success()
            ->send();
    }
}
