<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservasi;

class PaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reservasi;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservasi $reservasi)
    {
        $this->reservasi = $reservasi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Pembayaran Reservasi Workshop Griya Batik Tegal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_reminder',
            with: [
                'reservasi' => $this->reservasi,
                'jadwal' => $this->reservasi->jadwalWorkshop,
                'paket' => $this->reservasi->jadwalWorkshop->paketWorkshop,
            ],
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
