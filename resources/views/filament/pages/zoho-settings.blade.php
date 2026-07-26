<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">حالة الاتصال والربط مع Zoho CRM</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">حالة الإعدادات (.env)</div>
                    <div class="mt-1 text-lg font-semibold">
                        @if($isConfigured)
                            <span class="text-green-600 dark:text-green-400">مفعلة وتضم البيانات</span>
                        @else
                            <span class="text-red-600 dark:text-red-400">غير مكتملة أو معطلة</span>
                        @endif
                    </div>
                </div>

                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">آخر مزامنة ناجحة</div>
                    <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $lastSyncTime }}
                    </div>
                </div>

                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">إجمالي الحجوزات المزامنة</div>
                    <div class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">
                        {{ $syncedCount }} حجز
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h4 class="text-base font-bold text-gray-900 dark:text-white mb-3">دليل الحصول على Refresh Token دائم من Zoho (Self Client)</h4>
            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-600 dark:text-gray-300">
                <li>افتح بوابة المطورين <a href="https://api-console.zoho.com" target="_blank" class="text-primary-600 underline">api-console.zoho.com</a> وأنشئ تطبيق من نوع <strong>Self Client</strong>.</li>
                <li>في نافذة توليد الكود (Generate Code)، ادخل النطاق المطلوبة: <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">ZohoCRM.modules.leads.CREATE,ZohoCRM.modules.leads.READ</code>.</li>
                <li><strong class="text-red-600 dark:text-red-400">هام جداً:</strong> تأكد من اختيار مدة الصلاحية وتضمين المعاملات التالية عند الطلب: <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">access_type=offline</code> و <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">prompt=consent</code> لضمان صدور Refresh Token دائمة لا تنتهي بعد ساعة واحدة.</li>
                <li>انسخ الـ Grant Code واستبدله فوراً بـ Refresh Token بالاستعلام إلى endpoint التوكين لمرة واحدة.</li>
                <li>ضع القيم في ملف <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">.env</code> الخاص بالموقع: <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">ZOHO_CLIENT_ID</code>, <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">ZOHO_CLIENT_SECRET</code>, <code class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">ZOHO_REFRESH_TOKEN</code>.</li>
            </ol>
        </div>
    </div>
</x-filament-panels::page>
