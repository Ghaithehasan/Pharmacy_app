<?php

namespace App\Mail;

use App\Models\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupplierWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🌟 مرحبًا بك، {$this->supplier->company_name}!"
        );
    }

    /**
     * Get the message content definition.
     */
public function content(): Content
{
    return new Content(
        view: 'mail.supplier_welcome',
        with: [
            'supplierName' => $this->supplier->company_name,
            'supportEmail' => 'support@yourcompany.com',
            'dashboardUrl' => url("/supplier/dashboard/{$this->supplier->id}")
        ]
    );
}

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
