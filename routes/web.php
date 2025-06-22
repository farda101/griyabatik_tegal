<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PengrajinController;
use App\Http\Controllers\Admin\PaketWorkshopController;
use App\Http\Controllers\Admin\JadwalWorkshopController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\StockBatikController;
use App\Livewire\Kasir\PosPenjualan;
use App\Http\Controllers\Admin\StockBahanController;
use App\Http\Controllers\Admin\PenggunaanBahanController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Kasir\LaporanController as KasirLaporanController;


// Rute umum yang bisa diakses tanpa login atau untuk user publik
// PERBAIKAN DI SINI: Arahkan root URL ke PublicController@home
Route::get('/', [PublicController::class, 'home'])->name('home');

// --- Rute untuk Reservasi (Sisi Publik) ---
// Rute ini tidak memerlukan autentikasi
// Menampilkan form pendaftaran reservasi
Route::get('/reservasi/daftar', [ReservasiController::class, 'create'])->name('reservasi.create');
// Memproses pengajuan reservasi
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');

// Menampilkan form untuk cek status reservasi
Route::get('/reservasi/cek-status', [ReservasiController::class, 'showStatusCheckForm'])->name('reservasi.status.check.form');
// Memproses pengecekan status reservasi
Route::post('/reservasi/status', [ReservasiController::class, 'checkStatus'])->name('reservasi.status');

// --- Tambahan: Rute untuk menampilkan instruksi pembayaran manual ---
// Tambahkan parameter {reservasi} untuk Route Model Binding
Route::get('/reservasi/instruksi-pembayaran/{reservasi}', [ReservasiController::class, 'showPaymentInstructions'])->name('reservasi.payment_instructions');


// --- Tambahan: Rute untuk Menu Edukasi (Sisi Publik) ---
// Rute ini tidak memerlukan autentikasi
Route::prefix('edukasi')->name('edu.')->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('home');

    // Galeri
    Route::get('/galeri', [PublicController::class, 'galeriIndex'])->name('galeri.index');
    Route::get('/galeri/{galeri}', [PublicController::class, 'galeriShow'])->name('galeri.show'); // Untuk detail foto

    // Video
    Route::get('/video', [PublicController::class, 'videoIndex'])->name('video.index');
    Route::get('/video/{video}', [PublicController::class, 'videoShow'])->name('video.show'); // Untuk nonton video

    // Artikel
    Route::get('/artikel', [PublicController::class, 'artikelIndex'])->name('artikel.index');
    Route::get('/artikel/{artikel:slug}', [PublicController::class, 'artikelShow'])->name('artikel.show'); // Untuk baca artikel
    // Perhatikan: Menggunakan {artikel:slug} untuk Route Model Binding berdasarkan slug
});


// Dashboard umum (akses setelah login dan verifikasi email, jika diaktifkan)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Rute untuk pengelolaan profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rute untuk Admin Interface (Superadmin) ---
    // Rute ini hanya bisa diakses oleh pengguna dengan role 'superadmin'
    Route::middleware('role:superadmin')->group(function () {
        // PERBAIKAN DI SINI: Arahkan ke AdminController::index()
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // --- Tambahan: Rute untuk Export Laporan Penjualan (Admin) ---
        Route::get('/admin/laporan/penjualan/export', [AdminController::class, 'exportPenjualanReport'])->name('admin.laporan.penjualan.export');

        // Rute resource untuk Pengrajin
        Route::resource('admin/pengrajin', PengrajinController::class)
            ->names('admin.pengrajin');

        // Rute CUSTOM untuk mengubah status pengrajin
        Route::patch('admin/pengrajin/{pengrajin}/toggle-status', [PengrajinController::class, 'toggleStatus'])
            ->name('admin.pengrajin.toggleStatus');

        // Rute resource untuk Paket Workshop
        Route::resource('admin/paket-workshop', PaketWorkshopController::class)
            ->names('admin.paket_workshop');

        // Rute CUSTOM untuk mengubah status paket workshop
        Route::patch('admin/paket-workshop/{paket_workshop}/toggle-status', [PaketWorkshopController::class, 'toggleStatus'])
            ->name('admin.paket_workshop.toggleStatus');

        // Rute resource untuk Jadwal Workshop
        Route::resource('admin/jadwal-workshop', JadwalWorkshopController::class)
            ->names('admin.jadwal_workshop');

        // Rute CUSTOM untuk mengubah status jadwal workshop
        Route::patch('admin/jadwal-workshop/{jadwal_workshop}/toggle-status', [JadwalWorkshopController::class, 'toggleStatus'])
            ->name('admin.jadwal_workshop.toggleStatus');

        // Perbaikan penempatan untuk rute custom Reservasi
        Route::prefix('admin/reservasi')->name('admin.reservasi.')->group(function () {
            Route::get('export', [AdminReservasiController::class, 'export'])->name('export'); // Rute Export Excel
            Route::get('{reservasi}/download', [AdminReservasiController::class, 'downloadFilePermohonan'])->name('download');
        });
        // Resource sekarang di luar group prefix agar tidak bentrok dengan rute custom di atasnya
        Route::resource('admin/reservasi', AdminReservasiController::class)
            ->except(['create', 'store'])
            ->names('admin.reservasi');

        // Perbaikan penempatan untuk menghindari konflik dengan {stock_batik} di resource
        Route::prefix('admin/stock-batik')->name('admin.stock_batik.')->group(function () {
            Route::get('export', [StockBatikController::class, 'export'])->name('export'); // Rute Export Excel
            Route::get('{stock_batik}/download-qr', [StockBatikController::class, 'downloadQrCode'])->name('download_qr');
        });
        Route::resource('admin/stock-batik', StockBatikController::class)->names('admin.stock_batik');


        // Rute resource untuk Stok Bahan
        Route::resource('admin/stock-bahan', StockBahanController::class)
            ->names('admin.stock_bahan');
        
        // Rute resource untuk Penggunaan Bahan
        Route::resource('admin/penggunaan-bahan', PenggunaanBahanController::class)
            ->names('admin.penggunaan_bahan');

        // Rute resource untuk Galeri
        Route::resource('admin/galeri', GaleriController::class)
            ->names('admin.galeri');

        // Rute CUSTOM untuk mengubah status galeri
        Route::patch('admin/galeri/{galeri}/toggle-status', [GaleriController::class, 'toggleStatus'])
            ->name('admin.galeri.toggleStatus');

        // Rute resource untuk Video
        Route::resource('admin/video', VideoController::class)
            ->names('admin.video');

        // Rute CUSTOM untuk mengubah status video
        Route::patch('admin/video/{video}/toggle-status', [VideoController::class, 'toggleStatus'])
            ->name('admin.video.toggleStatus');

        // Rute resource untuk Artikel
        Route::resource('admin/artikel', ArtikelController::class)
            ->names('admin.artikel');

        // Rute CUSTOM untuk mengubah status artikel (draft/published)
        Route::patch('admin/artikel/{artikel}/toggle-status', [ArtikelController::class, 'toggleStatus'])
            ->name('admin.artikel.toggleStatus');

        // Tambahkan rute-rute lain khusus superadmin di sini (misal: users management, settings)
    });

    // --- Rute untuk Kasir Interface (Kasir & Superadmin) ---
    // Rute ini bisa diakses oleh pengguna dengan role 'kasir' ATAU 'superadmin'
    Route::middleware('role:kasir,superadmin')->group(function () {
        Route::get('/kasir/dashboard', [KasirLaporanController::class, 'dashboardKasirIndex'])->name('kasir.dashboard'); // Mengarahkan kasir dashboard ke LaporanController

        // Rute untuk Sistem POS Kasir (Livewire Component)
        Route::get('/kasir/pos', PosPenjualan::class)->name('kasir.pos');

        // --- Rute untuk Laporan Kasir ---
        Route::prefix('kasir/laporan')->name('kasir.laporan.')->group(function () {
            Route::get('/penjualan', [KasirLaporanController::class, 'penjualanIndex'])->name('penjualan.index');
            Route::get('/penjualan/export', [KasirLaporanController::class, 'exportPenjualan'])->name('penjualan.export');
            // Tambahkan rute untuk detail penjualan kasir
            Route::get('/penjualan/{penjualan}', [KasirLaporanController::class, 'penjualanShow'])->name('penjualan.show');
            
            Route::get('/stok', [KasirLaporanController::class, 'stokIndex'])->name('stok.index');
            Route::get('/reservasi', [KasirLaporanController::class, 'reservasiIndex'])->name('reservasi.index');
        });
        
        // Anda bisa menambahkan rute lain yang terkait dengan kasir di sini,
        // seperti laporan penjualan yang bisa dilihat kasir (read-only)
        // Route::get('/kasir/laporan-penjualan', [KasirLaporanController::class, 'index'])->name('kasir.laporan_penjualan');
        // Route::resource('kasir/penjualan', App\Http\Controllers\Kasir\PenjualanController::class)->except(['create', 'store', 'edit', 'update', 'destroy'])->names('kasir.penjualan');


        // Tambahkan rute-rute lain khusus kasir di sini (misal: reservasi yang hanya bisa dilihat kasir)
    });

    // --- Rute untuk Konten Publik yang dikelola Admin (misal: Galeri, Video, Artikel) ---
    // Rute ini mungkin bisa diakses oleh superadmin untuk mengelola konten, tapi kontennya sendiri publik
    // Atur perannya sesuai kebutuhan, mungkin cukup 'superadmin' saja untuk CRUD konten.
    // Route::middleware('role:superadmin')->group(function () {
    //     Route::resource('admin/galeri', App::Http\Controllers\Admin\GaleriController::class);
    //     Route::resource('admin/video', App::Http::Controllers\Admin\VideoController::class);
    //     Route::resource('admin/artikel', App::Http::Controllers\Admin\ArtikelController::class);
    // });
});

// Impor rute-rute autentikasi dari Laravel Breeze
require __DIR__.'/auth.php';