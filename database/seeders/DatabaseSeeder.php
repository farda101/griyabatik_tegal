<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PaketWorkshop;
use App\Models\Pengrajin;
use App\Models\Setting;
use App\Models\JadwalWorkshop;
use App\Models\Reservasi;
use App\Models\StockBatik;
use App\Models\StockBahan;
use App\Models\PenggunaanBahan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Default users
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@batikworkshop.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'is_active' => true,
        ]);

        $kasir = User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@batikworkshop.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'is_active' => true,
        ]);

        $kasir2 = User::create([
            'name' => 'Kasir 2',
            'email' => 'kasir2@batikworkshop.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'is_active' => true,
        ]);

        // Generate multiple clients (lebih realistis)
        $clients = [];
        for ($i = 1; $i <= 15; $i++) {
            $clients[] = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->email(),
                'password' => Hash::make('password'),
                'role' => 'client',
                'is_active' => true,
            ]);
        }

        // 2. Default settings
        Setting::create(['key' => 'app_name', 'value' => 'Workshop Wastra Tegalan']);
        Setting::create(['key' => 'whatsapp_api_key', 'value' => '']);
        Setting::create(['key' => 'midtrans_server_key', 'value' => '']);
        Setting::create(['key' => 'midtrans_client_key', 'value' => '']);
        Setting::create(['key' => 'min_stock_alert', 'value' => '5', 'type' => 'number', 'description' => 'Minimum stock level for batik products to trigger alert.']);
        Setting::create(['key' => 'min_stock_alert_bahan', 'value' => '10', 'type' => 'number', 'description' => 'Minimum stock level for raw materials to trigger alert.']);

        // 3. Multiple pengrajin (lebih realistis)
        $pengrajins = [
            Pengrajin::create([
                'kode_pengrajin' => '9901',
                'nama_pengrajin' => 'Pengrajin Wastra Tegalan Prima',
                'alamat' => 'Jl. Batik Jaya No. 1, Tegal',
                'telepon' => '08123456789',
                'is_active' => true,
            ]),
            Pengrajin::create([
                'kode_pengrajin' => '9902',
                'nama_pengrajin' => 'Batik Solo Heritage',
                'alamat' => 'Jl. Parangtritis No. 2, Solo',
                'telepon' => '08987654321',
                'is_active' => true,
            ]),
            Pengrajin::create([
                'kode_pengrajin' => '9903',
                'nama_pengrajin' => 'Cirebon Batik Center',
                'alamat' => 'Jl. Kejaksan No. 15, Cirebon',
                'telepon' => '08567891234',
                'is_active' => true,
            ]),
            Pengrajin::create([
                'kode_pengrajin' => '9904',
                'nama_pengrajin' => 'Pekalongan Batik House',
                'alamat' => 'Jl. Jetayu No. 8, Pekalongan',
                'telepon' => '08234567890',
                'is_active' => true,
            ]),
        ];

        // 4. Default paket workshop (lebih bervariasi)
        $pakets = [
            PaketWorkshop::create([
                'nama_paket' => 'Membatik Sapu Tangan',
                'deskripsi' => 'Belajar dasar membatik di sapu tangan.',
                'harga_individu' => 50000,
                'harga_kelompok' => 40000,
                'durasi_menit' => 120,
                'max_peserta' => 20,
                'is_active' => true,
            ]),
            PaketWorkshop::create([
                'nama_paket' => 'Membatik Taplak Meja',
                'deskripsi' => 'Teknik membatik lebih lanjut untuk taplak meja.',
                'harga_individu' => 75000,
                'harga_kelompok' => 60000,
                'durasi_menit' => 180,
                'max_peserta' => 15,
                'is_active' => true,
            ]),
            PaketWorkshop::create([
                'nama_paket' => 'Membatik Kain Panjang',
                'deskripsi' => 'Pengenalan teknik membatik pada kain ukuran besar.',
                'harga_individu' => 150000,
                'harga_kelompok' => 125000,
                'durasi_menit' => 300,
                'max_peserta' => 10,
                'is_active' => true,
            ]),
            PaketWorkshop::create([
                'nama_paket' => 'Membatik Tas Kanvas',
                'deskripsi' => 'Workshop membatik motif simple pada tas kanvas.',
                'harga_individu' => 85000,
                'harga_kelompok' => 70000,
                'durasi_menit' => 150,
                'max_peserta' => 18,
                'is_active' => true,
            ]),
            PaketWorkshop::create([
                'nama_paket' => 'Batik Tulis Traditional',
                'deskripsi' => 'Kelas advanced batik tulis dengan motif klasik.',
                'harga_individu' => 200000,
                'harga_kelompok' => 175000,
                'durasi_menit' => 360,
                'max_peserta' => 8,
                'is_active' => true,
            ]),
        ];

        // Data produk batik yang akan dirotasi
        $batikProducts = [
            ['nama' => 'Batik Motif Parang', 'motif' => 'Parang Rusak', 'ukuran' => '200x100 cm', 'harga_beli' => 120000, 'harga_jual' => 180000],
            ['nama' => 'Batik Mega Mendung', 'motif' => 'Mega Mendung', 'ukuran' => '150x80 cm', 'harga_beli' => 80000, 'harga_jual' => 120000],
            ['nama' => 'Batik Tiga Negeri', 'motif' => 'Tiga Negeri', 'ukuran' => '220x110 cm', 'harga_beli' => 200000, 'harga_jual' => 350000],
            ['nama' => 'Batik Kawung', 'motif' => 'Kawung', 'ukuran' => '180x90 cm', 'harga_beli' => 100000, 'harga_jual' => 150000],
            ['nama' => 'Batik Sekar Jagad', 'motif' => 'Sekar Jagad', 'ukuran' => '200x115 cm', 'harga_beli' => 180000, 'harga_jual' => 280000],
            ['nama' => 'Batik Truntum', 'motif' => 'Truntum', 'ukuran' => '160x85 cm', 'harga_beli' => 90000, 'harga_jual' => 140000],
            ['nama' => 'Batik Sidomukti', 'motif' => 'Sidomukti', 'ukuran' => '190x95 cm', 'harga_beli' => 130000, 'harga_jual' => 200000],
        ];

        // Data bahan yang akan dirotasi
        $bahanMaterials = [
            ['nama' => 'Kain Mori Prima', 'satuan' => 'meter', 'harga' => 25000],
            ['nama' => 'Kain Mori Super', 'satuan' => 'meter', 'harga' => 35000],
            ['nama' => 'Malam Batik', 'satuan' => 'kg', 'harga' => 50000],
            ['nama' => 'Pewarna Remazol Merah', 'satuan' => 'gram', 'harga' => 1500],
            ['nama' => 'Pewarna Remazol Biru', 'satuan' => 'gram', 'harga' => 1500],
            ['nama' => 'Pewarna Remazol Kuning', 'satuan' => 'gram', 'harga' => 1500],
            ['nama' => 'Canting Tulis No 1', 'satuan' => 'pcs', 'harga' => 15000],
            ['nama' => 'Canting Tulis No 2', 'satuan' => 'pcs', 'harga' => 18000],
            ['nama' => 'Garam Diazo', 'satuan' => 'kg', 'harga' => 45000],
        ];

        // 5. Generate data historis 6 bulan (180 hari)
        for ($i = 180; $i >= 0; $i--) {
            $currentDate = Carbon::today()->subDays($i);
            $currentDateString = $currentDate->toDateString();

            // Generate 2-4 jadwal workshop per hari secara random
            $dailySchedules = rand(2, 4);
            $createdSchedules = [];

            for ($j = 0; $j < $dailySchedules; $j++) {
                $randomPaket = $pakets[array_rand($pakets)];
                $timeSlots = [
                    ['start' => '09:00:00', 'end' => '11:00:00'],
                    ['start' => '13:00:00', 'end' => '15:00:00'],
                    ['start' => '15:30:00', 'end' => '17:30:00'],
                    ['start' => '10:00:00', 'end' => '12:00:00'],
                ];
                $randomTime = $timeSlots[array_rand($timeSlots)];

                $jadwal = JadwalWorkshop::create([
                    'paket_workshop_id' => $randomPaket->id,
                    'tanggal' => $currentDateString,
                    'jam_mulai' => $randomTime['start'],
                    'jam_selesai' => $randomTime['end'],
                    'max_peserta' => $randomPaket->max_peserta,
                    'peserta_terdaftar' => 0,
                    'status' => 'available',
                ]);

                $createdSchedules[] = $jadwal;
            }

            // Generate reservasi dengan probabilitas 60% untuk setiap jadwal
            foreach ($createdSchedules as $jadwal) {
                if (rand(1, 100) <= 60) { // 60% chance ada reservasi
                    $randomClient = $clients[array_rand($clients)];
                    $jenisPeserta = rand(1, 100) <= 30 ? 'kelompok' : 'individu'; // 30% kelompok
                    $jumlahPeserta = $jenisPeserta == 'kelompok' ? rand(3, min(8, $jadwal->max_peserta)) : 1;
                    $harga = $jenisPeserta == 'kelompok' ? $jadwal->paketWorkshop->harga_kelompok : $jadwal->paketWorkshop->harga_individu;

                    // Status pembayaran: 80% paid, 15% pending, 5% failed
                    $statusRand = rand(1, 100);
                    if ($statusRand <= 80) {
                        $statusPembayaran = 'paid';
                        $paidAt = $currentDate->copy()->addHours(rand(1, 6));
                        $midtransId = 'MIDTRANS-' . strtoupper(fake()->bothify('??##??##'));
                    } elseif ($statusRand <= 95) {
                        $statusPembayaran = 'pending';
                        $paidAt = null;
                        $midtransId = null;
                    } else {
                        $statusPembayaran = 'failed';
                        $paidAt = null;
                        $midtransId = 'FAILED-' . strtoupper(fake()->bothify('??##??##'));
                    }

                    $reservasi = Reservasi::create([
                        'nomor_reservasi' => Reservasi::generateNomorReservasi(),
                        'jadwal_workshop_id' => $jadwal->id,
                        'jenis_peserta' => $jenisPeserta,
                        'jumlah_peserta' => $jumlahPeserta,
                        'nama_pemesan' => $randomClient->name,
                        'email_pemesan' => $randomClient->email,
                        'telepon_pemesan' => fake('id')->phoneNumber(),
                        'alamat_pemesan' => fake('id')->streetAddress(),
                        'file_permohonan' => null,
                        'total_harga' => $harga * $jumlahPeserta,
                        'status_pembayaran' => $statusPembayaran,
                        'midtrans_transaction_id' => $midtransId,
                        'midtrans_response' => $midtransId ? json_encode(['status_code' => '200', 'gross_amount' => ($harga * $jumlahPeserta) . '.00']) : null,
                        'paid_at' => $paidAt,
                        'reminder_sent' => $statusPembayaran == 'paid',
                        'user_id' => $randomClient->id,
                        'created_at' => $currentDate,
                        'updated_at' => $paidAt ?? $currentDate,
                    ]);

                    // Update peserta terdaftar jika paid
                    if ($statusPembayaran == 'paid') {
                        $jadwal->peserta_terdaftar += $jumlahPeserta;
                        $jadwal->save();
                    }
                }
            }

            // Generate stock batik masuk setiap 3-7 hari sekali
            if ($i % rand(3, 7) == 0) {
                $randomBatik = $batikProducts[array_rand($batikProducts)];
                $randomPengrajin = $pengrajins[array_rand($pengrajins)];
                $qtyMasuk = rand(5, 25);

                $batik = StockBatik::create([
                    'pengrajin_id' => $randomPengrajin->id,
                    'nama_batik' => $randomBatik['nama'],
                    'deskripsi' => fake('id')->sentence(8),
                    'motif' => $randomBatik['motif'],
                    'ukuran' => $randomBatik['ukuran'],
                    'harga_beli' => $randomBatik['harga_beli'],
                    'harga_jual' => $randomBatik['harga_jual'],
                    'qty_masuk' => $qtyMasuk,
                    'qty_tersedia' => $qtyMasuk,
                    'qty_terjual' => 0,
                    'qr_code' => null,
                    'tanggal_masuk' => $currentDateString,
                ]);

                // Generate QR Code
                $qrCodeData = json_encode([
                    'kode' => $batik->kode_batik,
                    'nama' => $batik->nama_batik,
                    'pengrajin' => $batik->pengrajin->nama_pengrajin,
                    'harga_jual' => $batik->harga_jual,
                    'tanggal_masuk' => $batik->tanggal_masuk->format('Y-m-d'),
                ]);
                $qrPath = 'qr_codes/batik/batik_' . $batik->kode_batik . '.svg';
                \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->format('svg')->generate($qrCodeData, storage_path('app/public/' . $qrPath));
                $batik->update(['qr_code' => $qrPath]);
            }

            // Generate stock bahan masuk setiap 5-10 hari sekali
            if ($i % rand(5, 10) == 0) {
                $randomBahan = $bahanMaterials[array_rand($bahanMaterials)];
                $qtyMasuk = rand(20, 200);

                StockBahan::create([
                    'nama_bahan' => $randomBahan['nama'],
                    'satuan' => $randomBahan['satuan'],
                    'harga_satuan' => $randomBahan['harga'],
                    'qty_masuk' => $qtyMasuk,
                    'qty_tersedia' => $qtyMasuk,
                    'qty_terpakai' => 0,
                    'total_harga' => $randomBahan['harga'] * $qtyMasuk,
                    'qr_code' => null,
                    'tanggal_masuk' => $currentDateString,
                    'keterangan' => fake('id')->sentence(6),
                ]);
            }

            // Generate penjualan harian (1-3 transaksi per hari dengan probabilitas 70%)
            if (rand(1, 100) <= 70) {
                $dailySales = rand(1, 3);

                for ($s = 0; $s < $dailySales; $s++) {
                    // Ambil stok batik yang tersedia
                    $availableBatiks = StockBatik::where('qty_tersedia', '>', 0)
                        ->where('tanggal_masuk', '<=', $currentDateString)
                        ->get();

                    if ($availableBatiks->count() > 0) {
                        $itemCount = rand(1, min(3, $availableBatiks->count()));
                        $selectedBatiks = $availableBatiks->random($itemCount);

                        $totalHarga = 0;
                        $penjualan = Penjualan::create([
                            'nomor_nota' => Penjualan::generateNomorNota(),
                            'kasir_id' => rand(1, 2) == 1 ? $kasir->id : $kasir2->id,
                            'nama_pembeli' => fake()->name(),
                            'telepon_pembeli' => fake()->phoneNumber(),
                            'total_harga' => 0, // akan diupdate setelah detail
                            'total_bayar' => 0, // akan diupdate setelah detail
                            'kembalian' => 0, // akan diupdate setelah detail
                            'tanggal_penjualan' => $currentDate->copy()->addHours(rand(8, 17))->addMinutes(rand(0, 59)),
                        ]);

                        foreach ($selectedBatiks as $batik) {
                            $qtyJual = rand(1, min(3, $batik->qty_tersedia));
                            $subtotal = $batik->harga_jual * $qtyJual;
                            $totalHarga += $subtotal;

                            DetailPenjualan::create([
                                'penjualan_id' => $penjualan->id,
                                'stock_batik_id' => $batik->id,
                                'qty' => $qtyJual,
                                'harga_satuan' => $batik->harga_jual,
                                'subtotal' => $subtotal,
                            ]);

                            // Update stok batik
                            $batik->qty_tersedia -= $qtyJual;
                            $batik->qty_terjual += $qtyJual;
                            $batik->save();
                        }

                        // Update total penjualan
                        $totalBayar = $totalHarga + rand(0, 50000); // Kadang lebih bayar
                        $penjualan->update([
                            'total_harga' => $totalHarga,
                            'total_bayar' => $totalBayar,
                            'kembalian' => $totalBayar - $totalHarga,
                        ]);
                    }
                }
            }

            // Generate penggunaan bahan setiap 2-4 hari sekali
            if ($i % rand(2, 4) == 0) {
                $availableBahans = StockBahan::where('qty_tersedia', '>', 5)
                    ->where('tanggal_masuk', '<=', $currentDateString)
                    ->get();

                if ($availableBahans->count() > 0) {
                    $randomBahan = $availableBahans->random();
                    $qtyGunakan = rand(1, min(10, $randomBahan->qty_tersedia - 1));

                    PenggunaanBahan::create([
                        'stock_bahan_id' => $randomBahan->id,
                        'qty_digunakan' => $qtyGunakan,
                        'keperluan' => 'Produksi Kain Batik',
                        'keterangan' => 'Digunakan untuk produksi batch ' . strtoupper(fake()->bothify('B###')),
                        'tanggal_penggunaan' => $currentDateString,
                        'user_id' => rand(1, 2) == 1 ? $superadmin->id : $kasir->id,
                    ]);

                    // Update stok bahan
                    $randomBahan->qty_tersedia -= $qtyGunakan;
                    $randomBahan->qty_terpakai += $qtyGunakan;
                    $randomBahan->save();
                }
            }
        }

        // Generate some current/future schedules untuk testing
        for ($i = 1; $i <= 30; $i++) {
            $futureDate = Carbon::today()->addDays($i);
            $futureDateString = $futureDate->toDateString();

            $dailySchedules = rand(2, 4);

            for ($j = 0; $j < $dailySchedules; $j++) {
                $randomPaket = $pakets[array_rand($pakets)];
                $timeSlots = [
                    ['start' => '09:00:00', 'end' => '11:00:00'],
                    ['start' => '13:00:00', 'end' => '15:00:00'],
                    ['start' => '15:30:00', 'end' => '17:30:00'],
                    ['start' => '10:00:00', 'end' => '12:00:00'],
                ];
                $randomTime = $timeSlots[array_rand($timeSlots)];

                JadwalWorkshop::create([
                    'paket_workshop_id' => $randomPaket->id,
                    'tanggal' => $futureDateString,
                    'jam_mulai' => $randomTime['start'],
                    'jam_selesai' => $randomTime['end'],
                    'max_peserta' => $randomPaket->max_peserta,
                    'peserta_terdaftar' => 0,
                    'status' => 'available',
                ]);
            }
        }
    }
}
