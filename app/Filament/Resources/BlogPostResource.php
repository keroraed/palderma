<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-newspaper';

    protected static \UnitEnum|string|null $navigationGroup = 'المدونة';

    protected static ?string $navigationLabel = 'المقالات';

    protected static ?string $modelLabel = 'مقال';

    protected static ?string $pluralModelLabel = 'المقالات';

    protected static ?int $navigationSort = 0;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('post')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('المحتوى')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('عنوان المقال')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old) {
                                        $currentSlug = (string) $get('slug');
                                        if ($currentSlug === '' || $currentSlug === BlogPost::generateUniqueSlug((string) $old)) {
                                            $set('slug', $state ? BlogPost::generateUniqueSlug($state) : null);
                                        }
                                    })
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('slug')
                                    ->label('الرابط المختصر (Slug)')
                                    ->helperText('يُستخدم في رابط المقال: /blog/الرابط-المختصر — تجنّب تغييره بعد النشر لأن أي روابط أو مشاركات سابقة قد تتوقف عن العمل.')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->rule('regex:/^[\p{L}\p{N}-]+$/u')
                                    ->validationMessages(['regex' => 'الرابط المختصر يجب أن يحتوي على حروف وأرقام وشرطات فقط، بدون مسافات.'])
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('excerpt')
                                    ->label('مقتطف مختصر')
                                    ->helperText('يظهر في بطاقة المقال بصفحة المدونة، وكوصف احتياطي لمحركات البحث إن لم يُحدَّد وصف SEO مخصص.')
                                    ->rows(2)
                                    ->maxLength(300)
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('الصورة البارزة')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public_assets')
                                    ->directory('images/blog')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('content')
                                    ->label('محتوى المقال')
                                    ->required()
                                    // BlogPost doesn't implement Filament's HasRichContent contract,
                                    // so this uses the RichEditor's simple/direct attachment path
                                    // (HasFileAttachments trait) rather than the model-integrated
                                    // one — no FileAttachmentProvider needed, it just stores the
                                    // upload to the given disk/directory and inserts a plain <img
                                    // src="..."> at the cursor, same as any other public image on
                                    // this site. Sanitized on render like the rest of the content.
                                    ->fileAttachmentsDisk('public_assets')
                                    ->fileAttachmentsDirectory('images/blog/attachments')
                                    ->fileAttachmentsVisibility('public')
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'link'],
                                        ['h2', 'h3'],
                                        ['alignStart', 'alignCenter', 'alignEnd'],
                                        ['blockquote', 'bulletList', 'orderedList', 'attachFiles'],
                                        ['table', 'horizontalRule'],
                                        ['undo', 'redo'],
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\Repeater::make('gallery')
                                    ->label('معرض صور إضافية (اختياري)')
                                    ->helperText('لإدراج صورة داخل المقال في مكان معيّن، استخدمي زر الصورة 📎 داخل شريط أدوات المحرر أعلاه. هذا المعرض منفصل: صور تُعرض معًا في شبكة أسفل نهاية المقال، كل صورة بتعليق قصير يُستخدم أيضاً كنص بديل (Alt) لمحركات البحث.')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label('الصورة')
                                            ->image()
                                            ->disk('public_assets')
                                            ->directory('images/blog/gallery')
                                            ->required(),
                                        Forms\Components\TextInput::make('caption')
                                            ->label('تعليق / وصف الصورة')
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['caption'] ?? null)
                                    ->addActionLabel('إضافة صورة')
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('التصنيف والوسوم')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Forms\Components\Select::make('blog_category_id')
                                    ->label('التصنيف')
                                    ->options(fn () => BlogCategory::where('is_active', true)->orderBy('sort_order')->pluck('name', 'id'))
                                    ->searchable()
                                    ->native(false)
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('اسم التصنيف')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', $state ? BlogCategory::generateUniqueSlug($state) : null)),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('الرابط المختصر')
                                            ->required()
                                            ->unique('blog_categories', 'slug'),
                                    ])
                                    ->createOptionUsing(fn (array $data) => BlogCategory::create($data)->id),
                                Forms\Components\Select::make('tags')
                                    ->label('الوسوم')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->native(false)
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('اسم الوسم')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', $state ? BlogTag::generateUniqueSlug($state) : null)),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('الرابط المختصر')
                                            ->required()
                                            ->unique('blog_tags', 'slug'),
                                    ])
                                    ->createOptionUsing(fn (array $data) => BlogTag::create($data)->id),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('مقال مميّز')
                                    ->helperText('يظهر في قسم \"مقالات مميزة\" أعلى صفحة المدونة.')
                                    ->default(false),
                            ]),
                        Tabs\Tab::make('السيو (SEO)')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('عنوان الصفحة (Title Tag)')
                                    ->helperText('اتركه فارغاً لاستخدام عنوان المقال تلقائياً. الطول المثالي: 50-60 حرفاً.')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_description')
                                    ->label('وصف الصفحة (Meta Description)')
                                    ->helperText('اتركه فارغاً لاستخدام المقتطف المختصر تلقائياً. الطول المثالي: 150-160 حرفاً.')
                                    ->rows(2)
                                    ->maxLength(300)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_keywords')
                                    ->label('كلمات مفتاحية (اختياري)')
                                    ->helperText('كلمات مفصولة بفواصل. تأثيرها على الترتيب في جوجل ضعيف جداً حالياً، لكنها متاحة إن رغبتم بتوثيقها داخلياً.')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('canonical_url')
                                    ->label('الرابط الأساسي (Canonical URL)')
                                    ->helperText('استخدمه فقط إذا نُشر هذا المحتوى بالأصل في مكان آخر، لتوضيح لجوجل أيهما النسخة الأصلية.')
                                    ->url()
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('النشر')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('الحالة')
                                    ->options([
                                        BlogPost::STATUS_DRAFT => 'مسودة',
                                        BlogPost::STATUS_PUBLISHED => 'منشور',
                                    ])
                                    ->native(false)
                                    ->required()
                                    ->live()
                                    ->default(BlogPost::STATUS_DRAFT),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('تاريخ النشر')
                                    ->helperText('يمكن ضبطه بتاريخ مستقبلي لجدولة النشر.')
                                    ->native(false)
                                    ->visible(fn (Get $get) => $get('status') === BlogPost::STATUS_PUBLISHED)
                                    ->default(now()),
                                Forms\Components\Select::make('author_id')
                                    ->label('الكاتب')
                                    ->options(fn () => User::pluck('name', 'id'))
                                    ->searchable()
                                    ->native(false)
                                    ->default(fn () => auth()->id()),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('الصورة')
                    ->disk('public_assets'),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('التصنيف')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === BlogPost::STATUS_PUBLISHED ? 'منشور' : 'مسودة')
                    ->color(fn (string $state) => $state === BlogPost::STATUS_PUBLISHED ? 'success' : 'gray'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميّز')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('الكاتب')
                    ->placeholder('—'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        BlogPost::STATUS_DRAFT => 'مسودة',
                        BlogPost::STATUS_PUBLISHED => 'منشور',
                    ]),
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Actions\Action::make('preview')
                    ->label('معاينة')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (BlogPost $record) => route('blog.show', $record))
                    ->openUrlInNewTab(),
                Actions\Action::make('togglePublish')
                    ->label(fn (BlogPost $record) => $record->status === BlogPost::STATUS_PUBLISHED ? 'إلغاء النشر' : 'نشر الآن')
                    ->icon(fn (BlogPost $record) => $record->status === BlogPost::STATUS_PUBLISHED ? 'heroicon-o-eye-slash' : 'heroicon-o-check-circle')
                    ->color(fn (BlogPost $record) => $record->status === BlogPost::STATUS_PUBLISHED ? 'gray' : 'success')
                    ->requiresConfirmation()
                    ->action(function (BlogPost $record) {
                        if ($record->status === BlogPost::STATUS_PUBLISHED) {
                            $record->update(['status' => BlogPost::STATUS_DRAFT]);
                        } else {
                            $record->update([
                                'status' => BlogPost::STATUS_PUBLISHED,
                                'published_at' => $record->published_at ?? now(),
                            ]);
                        }
                    }),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['category', 'author']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
