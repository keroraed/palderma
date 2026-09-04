<?php

namespace App\Http\Controllers;

use App\Jobs\PushLeadToZoho;
use App\Mail\BookingNotificationMail;
use App\Models\Booking;
use App\Models\BookingOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Clinic working hours. The public form (and its native <input
     * type="time"> min/max) mirrors these — if the clinic's hours ever
     * change, update both.
     */
    private const OPENING_TIME = '09:00';

    private const CLOSING_TIME = '17:00';

    /**
     * The clinic's own timezone, used only to decide whether a submitted
     * same-day time has already passed. Deliberately not the app-wide
     * timezone (config('app.timezone') is UTC) — changing that globally
     * would shift every other timestamp in the app (published_at scheduling,
     * created_at display, …), which is out of scope here.
     */
    private const CLINIC_TIMEZONE = 'Asia/Riyadh';

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        // Spam honeypot check
        if ($request->filled('website_hp')) {
            return response()->json(['success' => true, 'message' => 'تم استلام طلبك بنجاح!']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:191'],
            'preferred_date' => ['nullable', 'required_with:preferred_time', 'date'],
            'preferred_time' => [
                'nullable',
                'required_with:preferred_date',
                'date_format:H:i',
                'after_or_equal:' . self::OPENING_TIME,
                'before_or_equal:' . self::CLOSING_TIME,
            ],
            'service_option_id' => ['required', 'exists:booking_service_options,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'يرجى إدخال الاسم الكامل.',
            'phone.required' => 'يرجى إدخال رقم الجوال.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'preferred_date.required_with' => 'يرجى تحديد تاريخ الموعد المفضل.',
            'preferred_date.date' => 'صيغة التاريخ غير صحيحة.',
            'preferred_time.required_with' => 'يرجى تحديد وقت الموعد المفضل.',
            'preferred_time.date_format' => 'صيغة الوقت غير صحيحة.',
            'preferred_time.after_or_equal' => 'مواعيد العيادة من الساعة 9 صباحاً حتى 5 مساءً.',
            'preferred_time.before_or_equal' => 'مواعيد العيادة من الساعة 9 صباحاً حتى 5 مساءً.',
            'service_option_id.required' => 'يرجى اختيار الخدمة المطلوبة.',
            'service_option_id.exists' => 'الخدمة المختارة غير متاحة، يرجى تحديث الصفحة والمحاولة مجدداً.',
            'notes.max' => 'الملاحظات طويلة جداً (الحد الأقصى 1000 حرف).',
        ]);

        // Whether the requested date is in the past, or is today but the
        // time has already gone by — both compared in the clinic's own
        // timezone rather than the server's (config('app.timezone') is UTC,
        // 3 hours behind Riyadh; a plain `after_or_equal:today` would be
        // wrong for part of the day).
        if (! empty($validated['preferred_date']) && ! empty($validated['preferred_time'])) {
            $requested = \Illuminate\Support\Carbon::parse(
                $validated['preferred_date'] . ' ' . $validated['preferred_time'],
                self::CLINIC_TIMEZONE
            );

            if ($requested->lt(now(self::CLINIC_TIMEZONE))) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'preferred_time' => 'هذا الموعد قد فات — يرجى اختيار تاريخ أو وقت لاحق.',
                ]);
            }
        }

        $serviceOption = BookingOption::findOrFail($validated['service_option_id']);

        $booking = Booking::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'preferred_date' => $validated['preferred_date'] ?? null,
            'preferred_time' => $validated['preferred_time'] ?? null,
            'service_option_id' => $serviceOption->id,
            'service_name' => $serviceOption->label,
            'notes' => $validated['notes'] ?? null,
            'pdpl_consent' => true,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'zoho_status' => 'pending',
        ]);

        // 1. Email notification to clinic
        $clinicEmail = env('CLINIC_NOTIFICATION_EMAIL', 'info@palderma.sa');
        try {
            Mail::to($clinicEmail)->send(new BookingNotificationMail($booking));
        } catch (\Throwable $e) {
            // Log mail failure but do not break booking submission
            \Illuminate\Support\Facades\Log::error('Booking email notification error: ' . $e->getMessage());
        }

        // 2. Dispatch Zoho lead push job after HTTP response
        PushLeadToZoho::dispatch($booking)->afterResponse();

        $successMsg = 'تم استلام طلب حجزك بنجاح! سيتواصل معك فريق الاستقبال خلال وقت قصير لتأكيد الموعد.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
                'booking_id' => $booking->id,
            ]);
        }

        return back()->with('success', $successMsg);
    }
}
