<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Jobs\PushLeadToZoho;
use App\Models\Booking;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static \UnitEnum|string|null $navigationGroup = 'إدارة الحجوزات';

    protected static ?string $modelLabel = 'حجز موعد';

    protected static ?string $pluralModelLabel = 'قائمة الحجوزات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->label('اسم المريض')
                    ->readOnly(),
                Forms\Components\TextInput::make('phone')
                    ->label('رقم الجوال')
                    ->readOnly(),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->readOnly(),
                Forms\Components\DatePicker::make('preferred_date')
                    ->label('الموعد المفضل')
                    ->readOnly(),
                Forms\Components\TextInput::make('service_name')
                    ->label('الخدمة / الباقة')
                    ->readOnly(),
                Forms\Components\Select::make('status')
                    ->label('حالة الحجز')
                    ->options([
                        'new' => 'جديد',
                        'contacted' => 'تم التواصل',
                        'booked' => 'مؤكد',
                        'attended' => 'حضر للمركز',
                        'no_answer' => 'لا يجيب',
                        'cancelled' => 'ملغي',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات المريض')
                    ->columnSpanFull()
                    ->readOnly(),
                Section::make('تفاصيل Zoho CRM')
                    ->schema([
                        Forms\Components\TextInput::make('zoho_lead_id')
                            ->label('معرف Lead في Zoho')
                            ->readOnly(),
                        Forms\Components\TextInput::make('zoho_status')
                            ->label('حالة المزامنة')
                            ->readOnly(),
                        Forms\Components\DateTimePicker::make('zoho_synced_at')
                            ->label('تاريخ المزامنة')
                            ->readOnly(),
                        Forms\Components\TextInput::make('zoho_attempts')
                            ->label('عدد المحاولات')
                            ->readOnly(),
                        Forms\Components\Textarea::make('zoho_error')
                            ->label('آخر خطأ')
                            ->columnSpanFull()
                            ->readOnly(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الجوال')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_name')
                    ->label('الخدمة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('preferred_date')
                    ->label('الموعد')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->label('حالة الحجز')
                    ->options([
                        'new' => 'جديد',
                        'contacted' => 'تم التواصل',
                        'booked' => 'مؤكد',
                        'attended' => 'حضر للمركز',
                        'no_answer' => 'لا يجيب',
                        'cancelled' => 'ملغي',
                    ]),
                Tables\Columns\BadgeColumn::make('zoho_status')
                    ->label('Zoho CRM')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'synced',
                        'danger' => 'failed',
                        'secondary' => 'skipped',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'معلق',
                        'synced' => 'مزامن',
                        'failed' => 'فشل',
                        'skipped' => 'متخطي',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('وقت الطلب')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('تصفية بحالة الحجز')
                    ->options([
                        'new' => 'جديد',
                        'contacted' => 'تم التواصل',
                        'booked' => 'مؤكد',
                        'attended' => 'حضر للمركز',
                        'no_answer' => 'لا يجيب',
                        'cancelled' => 'ملغي',
                    ]),
                Tables\Filters\SelectFilter::make('zoho_status')
                    ->label('تصفية بحالة Zoho')
                    ->options([
                        'pending' => 'معلق',
                        'synced' => 'مزامن',
                        'failed' => 'فشل',
                        'skipped' => 'متخطي',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('view_zoho_error')
                    ->label('عرض الخطأ')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->color('danger')
                    ->visible(fn (Booking $record) => !empty($record->zoho_error))
                    ->action(function (Booking $record) {
                        Notification::make()
                            ->title('تفاصيل خطأ مزامنة Zoho')
                            ->body($record->zoho_error)
                            ->persistent()
                            ->danger()
                            ->send();
                    }),
                Actions\Action::make('open_in_zoho')
                    ->label('فتح في Zoho')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('success')
                    ->visible(fn (Booking $record) => !empty($record->zoho_lead_id))
                    ->url(fn (Booking $record) => "https://crm.zoho.com/crm/tab/Leads/{$record->zoho_lead_id}")
                    ->openUrlInNewTab(),
                Actions\Action::make('retry_zoho')
                    ->label('إعادة المزامنة')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function (Booking $record) {
                        $record->update(['zoho_status' => 'pending', 'zoho_error' => null]);
                        PushLeadToZoho::dispatch($record)->afterResponse();
                        Notification::make()
                            ->title('تم إرسال طلب المزامنة الى Zoho')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\ForceDeleteBulkAction::make(),
                    Actions\RestoreBulkAction::make(),
                    Actions\BulkAction::make('retry_zoho_bulk')
                        ->label('إعادة مزامنة Zoho للمحدد')
                        ->icon('heroicon-o-arrow-path')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            foreach ($records as $record) {
                                $record->update(['zoho_status' => 'pending', 'zoho_error' => null]);
                                PushLeadToZoho::dispatch($record);
                            }
                            Notification::make()
                                ->title('تم إعادة جدولة المزامنة لجميع الحجوزات المحددة')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'view' => Pages\ViewBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
