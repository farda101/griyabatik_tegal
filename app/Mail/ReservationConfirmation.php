<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservasi;
use App\Models\JadwalWorkshop;

class ReservationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $reservasi;
    public $jadwal;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservasi $reservasi)
    {
        $this->reservasi = $reservasi;
        $this->jadwal = $reservasi->jadwalWorkshop;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Reservasi Workshop Griya Batik Tegal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_confirmation',
            with: [
                'reservasi' => $this->reservasi,
                'jadwal' => $this->jadwal,
                'paket' => $this->jadwal->paketWorkshop,
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
