<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'طلب حجز موعد جديد — ' . $this->booking->name,
        );
    }

    public function content(): Content
    {
        $preferredDate = $this->booking->preferred_date
            ? $this->booking->preferred_date->format('Y-m-d') . ($this->booking->preferred_time ? ' — الساعة ' . $this->booking->preferred_time : '')
            : 'غير محدد';

        return new Content(
            // The submitter's own name/phone/email/notes are interpolated
            // below — escaped with e(), since this is HTML mail and an
            // unescaped "name" is a stored-XSS path into whoever opens it.
            htmlString: "
                <div dir='rtl' style='font-family: sans-serif; padding: 20px;'>
                    <h2 style='color: #6c1830;'>طلب حجز موعد جديد في مجمع بالديرما الطبي</h2>
                    <p><strong>الاسم:</strong> " . e($this->booking->name) . "</p>
                    <p><strong>رقم الجوال:</strong> " . e($this->booking->phone) . "</p>
                    <p><strong>البريد الإلكتروني:</strong> " . e($this->booking->email ?? 'غير محدد') . "</p>
                    <p><strong>الخدمة/الباقة:</strong> " . e($this->booking->service_name) . "</p>
                    <p><strong>الموعد المفضل:</strong> " . e($preferredDate) . "</p>
                    <p><strong>الملاحظات:</strong> " . e($this->booking->notes ?? 'لا يوجد') . "</p>
                    <hr>
                    <p style='font-size: 12px; color: #777;'>تم إرسال هذا الإشعار تلقائياً فور تقديم طلب الحجز.</p>
                </div>
            ",
        );
    }
}
