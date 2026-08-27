<?php

namespace App\Filament\Resources\BlogPostResource\Pages;

use App\Filament\Resources\BlogPostResource;
use App\Models\BlogPost;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('معاينة المقال')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn (): string => route('blog.show', $this->record))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['status'] ?? null) === BlogPost::STATUS_PUBLISHED && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
