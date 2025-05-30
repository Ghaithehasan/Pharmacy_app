<?php

namespace App\Listeners;

use App\Events\SupplierRegistered;
use App\Mail\SupplierWelcomeEmail;
use App\Models\SupplierNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSupplierWelcomeNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SupplierRegistered $event): void
    {
        $notification = SupplierNotification::create([
            'supplier_id' => $event->supplier->id,
            'notification_type' => 'welcome_supplier_message',
            'message' => "مرحبًا {$event->supplier->company_name}! نحن سعداء بالتعامل معك.",
            'is_read' => false, // الإشعار غير مقروء عند إنشائه
        ]);

        // ✅ 2️⃣ إرسال إشعار ترحيبي عبر البريد الإلكتروني
        if (!empty($event->supplier->email)) {
            Mail::to($event->supplier->email)->send(new SupplierWelcomeEmail($event->supplier));
        }
    }
}
