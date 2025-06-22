<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PaketWorkshop;
use App\Models\Pengrajin;
use App\Models\Setting;
use App\Models\JadwalWorkshop; // Import model JadwalWorkshop
use App\Models\Reservasi;      // Import model Reservasi
use App\Models\StockBatik;     // Import model StockBatik
use App\Models\StockBahan;     // Import model StockBahan
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal/waktu

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

        // 2. Default settings
        Setting::create(['key' => 'app_name', 'value' => 'Workshop Batik Tegalan']);
        Setting::create(['key' => 'whatsapp_api_key', 'value' => '']);
        Setting::create(['key' => 'midtrans_server_key', 'value' => '']);
        Setting::create(['key' => 'midtrans_client_key', 'value' => '']);
        Setting::create(['key' => 'min_stock_alert', 'value' => '5', 'type' => 'number', 'description' => 'Minimum stock level for batik products to trigger alert.']);
        Setting::create(['key' => 'min_stock_alert_bahan', 'value' => '10', 'type' => 'number', 'description' => 'Minimum stock level for raw materials to trigger alert.']);


        // 3. Default pengrajin
        $pengrajin1 = Pengrajin::create([
            'kode_pengrajin' => '9901',
            'nama_pengrajin' => 'Pengrajin Batik Tegalan 1',
            'alamat' => 'Jl. Batik Jaya No. 1, Tegal',
            'telepon' => '08123456789',
            'is_active' => true,
        ]);

        $pengrajin2 = Pengrajin::create([
            'kode_pengrajin' => '9902',
            'nama_pengrajin' => 'Pengrajin Batik Solo',
            'alamat' => 'Jl. Parangtritis No. 2, Solo',
            'telepon' => '08987654321',
            'is_active' => true,
        ]);

        // 4. Default paket workshop
        $paket1 = PaketWorkshop::create([
            'nama_paket' => 'Membatik Sapu Tangan',
            'deskripsi' => 'Belajar dasar membatik di sapu tangan.',
            'harga_individu' => 50000,
            'harga_kelompok' => 40000,
            'durasi_menit' => 120, // 2 jam
            'max_peserta' => 20,
            'is_active' => true,
        ]);

        $paket2 = PaketWorkshop::create([
            'nama_paket' => 'Membatik Taplak Meja',
            'deskripsi' => 'Teknik membatik lebih lanjut untuk taplak meja.',
            'harga_individu' => 75000,
            'harga_kelompok' => 60000,
            'durasi_menit' => 180, // 3 jam
            'max_peserta' => 15,
            'is_active' => true,
        ]);

        $paket3 = PaketWorkshop::create([
            'nama_paket' => 'Membatik Kain Panjang',
            'deskripsi' => 'Pengenalan teknik membatik pada kain ukuran besar.',
            'harga_individu' => 150000,
            'harga_kelompok' => 125000,
            'durasi_menit' => 300, // 5 jam
            'max_peserta' => 10,
            'is_active' => true,
        ]);

        // 5. Default jadwal workshop
        $jadwal1 = JadwalWorkshop::create([
            'paket_workshop_id' => $paket1->id,
            'tanggal' => Carbon::today()->addDays(2)->toDateString(), // 2 hari dari sekarang
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'max_peserta' => 20,
            'peserta_terdaftar' => 0,
            'status' => 'available',
        ]);

        $jadwal2 = JadwalWorkshop::create([
            'paket_workshop_id' => $paket2->id,
            'tanggal' => Carbon::today()->addDays(3)->toDateString(), // 3 hari dari sekarang
            'jam_mulai' => '14:00:00',
            'jam_selesai' => '17:00:00',
            'max_peserta' => 15,
            'peserta_terdaftar' => 5, // Sudah ada 5 peserta
            'status' => 'available',
        ]);

        $jadwal3 = JadwalWorkshop::create([
            'paket_workshop_id' => $paket3->id,
            'tanggal' => Carbon::today()->addDays(5)->toDateString(), // 5 hari dari sekarang
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '15:00:00',
            'max_peserta' => 10,
            'peserta_terdaftar' => 10, // Jadwal ini penuh
            'status' => 'full',
        ]);
        
        $jadwal4 = JadwalWorkshop::create([
            'paket_workshop_id' => $paket1->id,
            'tanggal' => Carbon::today()->subDays(1)->toDateString(), // Jadwal kemarin (sudah lewat)
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '11:00:00',
            'max_peserta' => 20,
            'peserta_terdaftar' => 18,
            'status' => 'available',
        ]);


        // 6. Default reservasi
        $reservasi1 = Reservasi::create([
            'nomor_reservasi' => Reservasi::generateNomorReservasi(), // Otomatis generate
            'jadwal_workshop_id' => $jadwal2->id, // Reservasi untuk jadwal2
            'jenis_peserta' => 'kelompok',
            'jumlah_peserta' => 5,
            'nama_pemesan' => 'Budi Santoso',
            'email_pemesan' => 'budi@example.com',
            'telepon_pemesan' => '081212345678',
            'alamat_pemesan' => 'Jl. Merdeka No. 10, Jakarta',
            'file_permohonan' => null, // Contoh tanpa file
            'total_harga' => $paket2->harga_kelompok * 5, // 60000 * 5 = 300000
            'status_pembayaran' => 'pending', // Awalnya pending
            'midtrans_transaction_id' => null,
            'midtrans_response' => null,
            'paid_at' => null,
            'reminder_sent' => false,
        ]);
        
        $reservasi2 = Reservasi::create([
            'nomor_reservasi' => Reservasi::generateNomorReservasi(),
            'jadwal_workshop_id' => $jadwal1->id,
            'jenis_peserta' => 'individu',
            'jumlah_peserta' => 1,
            'nama_pemesan' => 'Siti Aminah',
            'email_pemesan' => 'siti@example.com',
            'telepon_pemesan' => '087812345678',
            'alamat_pemesan' => 'Jl. Kebon Jeruk No. 5, Bandung',
            'file_permohonan' => null,
            'total_harga' => $paket1->harga_individu * 1, // 50000 * 1 = 50000
            'status_pembayaran' => 'paid', // Contoh yang sudah paid
            'midtrans_transaction_id' => 'MIDTRANS-12345',
            'midtrans_response' => json_encode(['status_code' => '200', 'gross_amount' => '50000.00']),
            'paid_at' => Carbon::now()->subHours(2), // 2 jam lalu
            'reminder_sent' => true,
        ]);
        // Update peserta terdaftar di jadwal workshop setelah reservasi paid
        $reservasi2->jadwalWorkshop->updatePesertaTerdaftar();


        // 7. Default stok batik
        $batik1 = StockBatik::create([
            // 'kode_batik' akan di-generate otomatis di model
            'pengrajin_id' => $pengrajin1->id,
            'nama_batik' => 'Batik Motif Parang',
            'deskripsi' => 'Batik tulis motif klasik Parang Rusak.',
            'motif' => 'Parang Rusak',
            'ukuran' => '200x100 cm',
            'harga_beli' => 120000.00,
            'harga_jual' => 180000.00,
            'qty_masuk' => 15,
            'qty_tersedia' => 15, // Default dari boot method di model
            'qty_terjual' => 0,    // Default dari boot method di model
            'qr_code' => null,     // Akan diisi setelah model dibuat di controller
            'tanggal_masuk' => Carbon::today()->subDays(10)->toDateString(), // 10 hari lalu
        ]);
        // Generate QR Code untuk batik ini (simulasi dari controller)
        $qrCodeDataBatik1 = json_encode([
            'kode' => $batik1->kode_batik,
            'nama' => $batik1->nama_batik,
            'pengrajin' => $batik1->pengrajin->nama_pengrajin,
            'harga_jual' => $batik1->harga_jual,
            'tanggal_masuk' => $batik1->tanggal_masuk->format('Y-m-d'),
        ]);
        $qrPathBatik1 = 'qr_codes/batik/batik_' . $batik1->kode_batik . '.svg';
        \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->format('svg')->generate($qrCodeDataBatik1, storage_path('app/public/' . $qrPathBatik1));
        $batik1->update(['qr_code' => $qrPathBatik1]);


        $batik2 = StockBatik::create([
            // 'kode_batik' akan di-generate otomatis di model
            'pengrajin_id' => $pengrajin2->id,
            'nama_batik' => 'Batik Mega Mendung',
            'deskripsi' => 'Batik cap motif awan khas Cirebon.',
            'motif' => 'Mega Mendung',
            'ukuran' => '150x80 cm',
            'harga_beli' => 80000.00,
            'harga_jual' => 120000.00,
            'qty_masuk' => 20,
            'qty_tersedia' => 18, // Contoh: sudah terjual 2
            'qty_terjual' => 2,
            'qr_code' => null,
            'tanggal_masuk' => Carbon::today()->subDays(5)->toDateString(), // 5 hari lalu
        ]);
        // Generate QR Code untuk batik ini
        $qrCodeDataBatik2 = json_encode([
            'kode' => $batik2->kode_batik,
            'nama' => $batik2->nama_batik,
            'pengrajin' => $batik2->pengrajin->nama_pengrajin,
            'harga_jual' => $batik2->harga_jual,
            'tanggal_masuk' => $batik2->tanggal_masuk->format('Y-m-d'),
        ]);
        $qrPathBatik2 = 'qr_codes/batik/batik_' . $batik2->kode_batik . '.svg';
        \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->format('svg')->generate($qrCodeDataBatik2, storage_path('app/public/' . $qrPathBatik2));
        $batik2->update(['qr_code' => $qrPathBatik2]);


        $batik3 = StockBatik::create([
            // 'kode_batik' akan di-generate otomatis di model
            'pengrajin_id' => $pengrajin1->id,
            'nama_batik' => 'Batik Tiga Negeri',
            'deskripsi' => 'Batik dengan perpaduan warna khas Tiga Negeri.',
            'motif' => 'Tiga Negeri',
            'ukuran' => '220x110 cm',
            'harga_beli' => 200000.00,
            'harga_jual' => 350000.00,
            'qty_masuk' => 5,
            'qty_tersedia' => 2, // Contoh: stok rendah
            'qty_terjual' => 3,
            'qr_code' => null,
            'tanggal_masuk' => Carbon::today()->subDays(20)->toDateString(), // 20 hari lalu
        ]);
        // Generate QR Code untuk batik ini
        $qrCodeDataBatik3 = json_encode([
            'kode' => $batik3->kode_batik,
            'nama' => $batik3->nama_batik,
            'pengrajin' => $batik3->pengrajin->nama_pengrajin,
            'harga_jual' => $batik3->harga_jual,
            'tanggal_masuk' => $batik3->tanggal_masuk->format('Y-m-d'),
        ]);
        $qrPathBatik3 = 'qr_codes/batik/batik_' . $batik3->kode_batik . '.svg';
        \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->format('svg')->generate($qrCodeDataBatik3, storage_path('app/public/' . $qrPathBatik3));
        $batik3->update(['qr_code' => $qrPathBatik3]);


        // 8. Default stok bahan
        $bahan1 = StockBahan::create([
            // 'kode_bahan' akan di-generate otomatis di model
            'nama_bahan' => 'Kain Mori Prima',
            'satuan' => 'meter',
            'harga_satuan' => 25000.00,
            'qty_masuk' => 100,
            'qty_tersedia' => 100, // Default dari boot method di model
            'qty_terpakai' => 0,    // Default dari boot method di model
            'total_harga' => 25000 * 100, // Akan dihitung ulang di model
            'qr_code' => null, // Jika ada QR code bahan
            'tanggal_masuk' => Carbon::today()->subDays(30)->toDateString(),
            'keterangan' => 'Bahan dasar kain putih untuk batik tulis.',
        ]);

        $bahan2 = StockBahan::create([
            // 'kode_bahan' akan di-generate otomatis di model
            'nama_bahan' => 'Malam Batik',
            'satuan' => 'kg',
            'harga_satuan' => 50000.00,
            'qty_masuk' => 50,
            'qty_tersedia' => 45, // Sudah terpakai 5
            'qty_terpakai' => 5,
            'total_harga' => 50000 * 50, // Akan dihitung ulang di model
            'qr_code' => null,
            'tanggal_masuk' => Carbon::today()->subDays(15)->toDateString(),
            'keterangan' => 'Malam berkualitas tinggi untuk proses canting.',
        ]);

        $bahan3 = StockBahan::create([
            'nama_bahan' => 'Pewarna Remazol Merah',
            'satuan' => 'gram',
            'harga_satuan' => 1500.00,
            'qty_masuk' => 200,
            'qty_tersedia' => 10, // Stok rendah
            'qty_terpakai' => 190,
            'total_harga' => 1500 * 200,
            'qr_code' => null,
            'tanggal_masuk' => Carbon::today()->subDays(5)->toDateString(),
            'keterangan' => 'Pewarna batik sintetis merah.',
        ]);
        
        // Simulasikan penggunaan bahan
        \App\Models\PenggunaanBahan::create([
            'stock_bahan_id' => $bahan2->id,
            'qty_digunakan' => 5,
            'keperluan' => 'Produksi Kain Batik',
            'keterangan' => 'Digunakan untuk produksi batch B001',
            'tanggal_penggunaan' => Carbon::today()->subDays(10)->toDateString(),
            'user_id' => $superadmin->id, // Atau id kasir jika mereka bisa mencatat penggunaan
        ]);
        // Update qty_tersedia bahan2 setelah penggunaan (simulasi dari controller)
        // $bahan2->kurangiBahan(5); // ini sudah dilakukan di data bahan2 di atas


        // Simulasikan penjualan dari Kasir POS
        // Gunakan $batik1 (tersedia 15) dan $batik2 (tersedia 18)
        $penjualan1 = \App\Models\Penjualan::create([
            'nomor_nota' => \App\Models\Penjualan::generateNomorNota(),
            'kasir_id' => $kasir->id,
            'nama_pembeli' => 'Pelanggan A',
            'telepon_pembeli' => '081122334455',
            'total_harga' => ($batik1->harga_jual * 1) + ($batik2->harga_jual * 1), // 180000 + 120000 = 300000
            'total_bayar' => 300000,
            'kembalian' => 0,
            'tanggal_penjualan' => Carbon::now()->subHours(1),
        ]);

        \App\Models\DetailPenjualan::create([
            'penjualan_id' => $penjualan1->id,
            'stock_batik_id' => $batik1->id,
            'qty' => 1,
            'harga_satuan' => $batik1->harga_jual,
            'subtotal' => $batik1->harga_jual * 1,
        ]);
        $batik1->kurangiStock(1); // Kurangi stok batik1

        \App\Models\DetailPenjualan::create([
            'penjualan_id' => $penjualan1->id,
            'stock_batik_id' => $batik2->id,
            'qty' => 1,
            'harga_satuan' => $batik2->harga_jual,
            'subtotal' => $batik2->harga_jual * 1,
        ]);
        $batik2->kurangiStock(1); // Kurangi stok batik2
    }
}