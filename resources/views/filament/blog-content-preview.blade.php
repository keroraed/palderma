@php
    // Rendered through the same sanitizer the public article page uses, so the
    // admin previews exactly what visitors will get — not the raw editor HTML.
    $safeContent = \Illuminate\Support\Str::sanitizeHtml($content);

    $isEmpty = trim(strip_tags($safeContent, '<img><table><hr>')) === ''
        && ! \Illuminate\Support\Str::contains($safeContent, ['<img', '<table', '<hr']);

    // Same cache-busted URL the public layout uses, so the preview never renders
    // against a stale cached copy of the stylesheet.
    $cssUrl = e(asset('css/site.css') . '?v=' . @filemtime(public_path('css/site.css')));

    // A complete standalone document: the iframe loads the live site.css, so the
    // preview picks up the real Thmanyah font and .blog-article-content rules and
    // stays in sync automatically whenever those styles change.
    $document = <<<HTML
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="{$cssUrl}">
            <style>
                body { margin: 0; background: #fff; }
                .preview-shell { max-width: 748px; margin: 0 auto; padding: 28px 26px 40px; }
            </style>
        </head>
        <body>
            <div class="preview-shell">
                <div class="blog-article-content">{$safeContent}</div>
            </div>
        </body>
        </html>
        HTML;
@endphp

<div class="fi-modal-content">
    @if($isEmpty)
        <div style="padding:48px 24px;text-align:center;color:#71717a;font-size:14px">
            لا يوجد محتوى لعرضه بعد — اكتبي نص المقال أولاً ثم افتحي المعاينة.
        </div>
    @else
        <div style="border:1px solid rgba(0,0,0,.1);border-radius:12px;overflow:hidden;background:#fff">
            <iframe
                title="معاينة المقال"
                sandbox="allow-same-origin"
                srcdoc="{{ $document }}"
                style="width:100%;height:65vh;border:0;display:block;background:#fff"
            ></iframe>
        </div>
        <p style="margin:12px 2px 0;font-size:12.5px;color:#71717a">
            المعاينة تعرض تنسيق النص فقط (العناوين، الفقرات، القوائم، الاقتباسات، الكود، الجداول والصور).
            العنوان والصورة البارزة ومعلومات الكاتب تظهر تلقائياً في الصفحة النهائية.
        </p>
    @endif
</div>
