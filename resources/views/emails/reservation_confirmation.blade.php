<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Reservasi Workshop Griya Batik Tegal</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 8px; margin-bottom: 20px; }
        .content { background-color: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; }
        .section { margin-bottom: 20px; }
        .section h3 { color: #495057; border-bottom: 2px solid #007bff; padding-bottom: 5px; }
        .detail-row { display: flex; margin-bottom: 8px; }
        .detail-label { font-weight: bold; width: 150px; }
        .detail-value { flex: 1; }
        .ticket-code { background-color: #e9ecef; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 16px; text-align: center; margin: 10px 0; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6; font-size: 14px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Konfirmasi Reservasi Workshop</h1>
            <p>Griya Batik Tegal</p>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $reservasi->nama_pemesan }}</strong>,</p>
            <p>Terima kasih telah melakukan reservasi workshop di Griya Batik Tegal. Berikut detail tiket dan jadwal workshop Anda.</p>

            <div class="section">
                <h3>Detail Workshop</h3>
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
                    <span class="detail-label">Lokasi:</span>
                    <span class="detail-value">Griya Batik Tegal, Jl. Raya Adiwerna No. 23, Tegal</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Paket Membatik:</span>
                    <span class="detail-value">{{ $paket->nama_paket }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jumlah Peserta:</span>
                    <span class="detail-value">{{ $reservasi->jumlah_peserta }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status Pembayaran:</span>
                    <span class="detail-value">{{ ucfirst($reservasi->status_pembayaran) }}</span>
                </div>
            </div>

            <div class="section">
                <h3>Informasi Tiket</h3>
                <p>Kode Tiket:</p>
                <div class="ticket-code">{{ $reservasi->nomor_reservasi }}</div>
                <p>Silakan tunjukkan kode tiket saat melakukan check-in di lokasi workshop.</p>
            </div>

            <div class="section">
                <h3>Catatan Penting</h3>
                <ul>
                    <li>Harap datang 15 menit sebelum jadwal dimulai.</li>
                    <li>Tunjukkan QR code atau kode tiket kepada petugas saat check-in.</li>
                    <li>Perubahan jadwal dapat dilakukan maksimal 3 hari sebelum acara (H–3).</li>
                    <li>Jika workshop dibatalkan oleh pihak Griya Batik (misalnya tidak memenuhi jumlah peserta minimal), peserta akan dihubungi untuk memilih opsi penjadwalan ulang atau pengembalian dana (refund).</li>
                </ul>
            </div>

            <div class="section">
                <h3>Kontak Layanan</h3>
                <p>Jika Anda membutuhkan bantuan atau informasi lebih lanjut, hubungi kami di:</p>
                <ul>
                    <li><strong>WhatsApp:</strong> 0815-4505-5603</li>
                    <li><strong>Email:</strong> info@griyabatiktegal.com</li>
                    <li><strong>Website:</strong> www.disnakerin.tegalkota.go.id</li>
                </ul>
            </div>

            <p>Terima kasih atas partisipasi Anda dalam melestarikan budaya membatik Indonesia. Kami nantikan kehadiran Anda di workshop.</p>

            <div class="footer">
                <p>Hormat kami,<br>Tim Griya Batik Tegal</p>
            </div>
        </div>
    </div>
</body>
</html>
