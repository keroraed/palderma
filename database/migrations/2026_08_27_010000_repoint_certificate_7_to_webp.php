<?php

use App\Models\Certification;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * certificate-7 was a 624KB palette PNG — by far the heaviest certificate.
     * Re-encoded to WebP (164KB) as part of the SEO image-compression pass;
     * this repoints the stored path at the new file.
     */
    public function up(): void
    {
        Certification::where('image', 'images/certificates/certificate-7.png')
            ->update(['image' => 'images/certificates/certificate-7.webp']);
    }

    public function down(): void
    {
        Certification::where('image', 'images/certificates/certificate-7.webp')
            ->update(['image' => 'images/certificates/certificate-7.png']);
    }
};
