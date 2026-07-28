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
            'preferred_date' => ['nullable', 'date'],
            'service_option_id' => ['required', 'exists:booking_service_options,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $serviceOption = BookingOption::findOrFail($validated['service_option_id']);

        $booking = Booking::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'preferred_date' => $validated['preferred_date'] ?? null,
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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
                'booking_id' => $booking->id,
            ]);
        }

        return back()->with('success', $successMsg);
    }
}
