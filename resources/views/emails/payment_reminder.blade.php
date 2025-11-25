<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Pembayaran Reservasi Workshop Griya Batik Tegal</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #fff3cd; padding: 20px; text-align: center; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffeaa7; }
        .content { background-color: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; }
        .section { margin-bottom: 20px; }
        .section h3 { color: #856404; border-bottom: 2px solid #ffc107; padding-bottom: 5px; }
        .detail-row { display: flex; margin-bottom: 8px; }
        .detail-label { font-weight: bold; width: 150px; }
        .detail-value { flex: 1; }
        .warning { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .payment-button { display: inline-block; background-color: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; margin: 10px 0; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6; font-size: 14px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pengingat Pembayaran</h1>
            <p>Reservasi Workshop Griya Batik Tegal</p>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $reservasi->nama_pemesan }}</strong>,</p>
            <p>Kami ingin mengingatkan bahwa batas waktu pembayaran untuk reservasi workshop Anda akan segera berakhir.</p>

            <div class="warning">
                <strong>Perhatian!</strong> Reservasi Anda akan otomatis dibatalkan jika pembayaran tidak dilakukan sebelum batas waktu yang ditentukan.
            </div>

            <div class="section">
                <h3>Detail Reservasi</h3>
                <div class="detail-row">
                    <span class="detail-label">Nomor Reservasi:</span>
                    <span class="detail-value">{{ $reservasi->nomor_reservasi }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Workshop:</span>
                    <span class="detail-value">{{ $paket->nama_paket }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Waktu:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jumlah Peserta:</span>
                    <span class="detail-value">{{ $reservasi->jumlah_peserta }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Pembayaran:</span>
                    <span class="detail-value">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Batas Pembayaran:</span>
                    <span class="detail-value"><strong>{{ \Carbon\Carbon::parse($reservasi->payment_deadline)->format('d M Y H:i') }} WIB</strong></span>
                </div>
            </div>

            <div class="section">
                <h3>Cara Pembayaran</h3>
                <p>Silakan selesaikan pembayaran melalui metode yang telah disediakan. Setelah pembayaran berhasil, status reservasi Anda akan diperbarui secara otomatis.</p>
                <p>Jika Anda sudah melakukan pembayaran, abaikan email ini.</p>
            </div>

            <div class="section">
                <h3>Kontak Layanan</h3>
                <p>Jika Anda mengalami kesulitan atau memiliki pertanyaan, hubungi kami di:</p>
                <ul>
                    <li><strong>WhatsApp:</strong> 0815-4505-5603</li>
                    <li><strong>Email:</strong> info@griyabatiktegal.com</li>
                    <li><strong>Website:</strong> www.disnakerin.tegalkota.go.id</li>
                </ul>
            </div>

            <p>Terima kasih atas perhatian Anda. Kami menantikan konfirmasi pembayaran Anda.</p>

            <div class="footer">
                <p>Hormat kami,<br>Tim Griya Batik Tegal</p>
            </div>
        </div>
    </div>
</body>
</html>
