<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $baseUrl;
    protected $token;
    protected $senderId;
    protected $accountSid;
    protected $testReceiverNumber;

    public function __construct()
    {
        $this->baseUrl = config('services.whatsapp.base_url');
        $this->token = config('services.whatsapp.token');
        $this->senderId = config('services.whatsapp.sender_id');
        $this->accountSid = config('services.whatsapp.account_sid');
        $this->testReceiverNumber = config('services.whatsapp.test_receiver_number');

        // Pastikan konfigurasi sudah diatur
        if (empty($this->baseUrl) || empty($this->token) || empty($this->senderId) || empty($this->accountSid)) {
            Log::warning('WhatsApp API configuration is incomplete. Base URL, Token, Sender ID, or Account SID is missing.');
        }
    }

    /**
     * Mengirim pesan teks via WhatsApp menggunakan Twilio API.
     *
     * @param string $to Nomor tujuan (dengan kode negara, tanpa +) misal: 628123456789
     * @param string $message Isi pesan
     * @return bool True jika berhasil, false jika gagal
     */
    public function sendMessage(string $to, string $message): bool
    {
        if (empty($this->baseUrl) || empty($this->token) || empty($this->senderId) || empty($this->accountSid)) {
            Log::error('Attempted to send WhatsApp message with incomplete configuration.');
            return false;
        }

        // Jika di lingkungan lokal (development), kirim ke nomor uji coba yang terdaftar di Twilio Sandbox
        // Ini MENCEGAH PENGIRIMAN KE NOMOR PELANGGAN ASLI SAAT DEV
        if (app()->environment('local') && !empty($this->testReceiverNumber)) {
            Log::info("MODE DEV: Mengirim pesan WhatsApp ke nomor UJI COBA ({$this->testReceiverNumber}) BUKAN {$to}");
            $to = $this->testReceiverNumber;
        }

        // Twilio memerlukan format "whatsapp:+Nomor" untuk From dan To
        $toFormatted = 'whatsapp:+' . $to;
        $fromFormatted = $this->senderId; // Sender ID sudah dalam format whatsapp:+1415...

        try {
            $response = Http::withBasicAuth($this->accountSid, $this->token) // Basic Auth untuk Twilio
                            ->asForm() // Mengirim data sebagai form-urlencoded
                            ->post($this->baseUrl . '/' . $this->accountSid . '/Messages.json', [
                                'From' => $fromFormatted,
                                'To' => $toFormatted,
                                'Body' => $message,
                            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully to ' . $to . ' (via Twilio). Response: ' . $response->body());
                return true;
            } else {
                $errorBody = $response->json(); // Coba dapatkan response JSON
                $errorMessage = $errorBody['message'] ?? 'No specific error message from Twilio.';
                Log::error('Failed to send WhatsApp message to ' . $to . ' (via Twilio): ' . $errorMessage . ' Full Response: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending WhatsApp message via Twilio: ' . $e->getMessage(), ['exception' => $e]);
            return false;
        }
    }
}