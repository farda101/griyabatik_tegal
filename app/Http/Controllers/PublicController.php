<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;    // Import models
use App\Models\Video;
use App\Models\Artikel;
use App\Models\JadwalWorkshop; // Tambahkan ini
use App\Models\PaketWorkshop; // Tambahkan ini (jika perlu detail paket di home)
use Carbon\Carbon; // Tambahkan ini
use Illuminate\Support\Facades\DB; // Tambahkan baris ini


class PublicController extends Controller
{
    /**
     * Menampilkan halaman utama publik (overview).
     */
    public function home()
    {
        // Ambil 3 jadwal workshop yang available dan belum penuh, terdekat di masa depan
        $upcomingWorkshops = JadwalWorkshop::with('paketWorkshop')
                                ->available()
                                ->where('peserta_terdaftar', '<', \DB::raw('max_peserta'))
                                ->where('tanggal', '>=', Carbon::today()->toDateString())
                                ->orderBy('tanggal')
                                ->orderBy('jam_mulai')
                                ->take(3)
                                ->get();

        // Ambil 3 artikel terbaru yang sudah dipublikasikan
        $latestArticles = Artikel::published()->latest('published_at')->take(3)->get();

        // Ambil 3 video edukasi terbaru yang aktif
        $latestVideos = Video::active()->latest('created_at')->take(3)->get();

        // Ambil 6 foto galeri terbaru yang aktif
        $latestGalleries = Galeri::active()->latest('created_at')->take(6)->get();

        return view('public.home', compact('upcomingWorkshops', 'latestArticles', 'latestVideos', 'latestGalleries'));
    }
    
    /**
     * Menampilkan halaman utama Menu Edukasi.
     */
    public function index()
    {
        // Ambil beberapa data terbaru/populer untuk ditampilkan di halaman depan edukasi
        $latestArticles = Artikel::published()->latest('published_at')->take(3)->get();
        $latestVideos = Video::active()->latest()->take(3)->get();
        $latestGalleries = Galeri::active()->orderBy('urutan')->take(6)->get();

        return view('public.edu_home', compact('latestArticles', 'latestVideos', 'latestGalleries'));
    }

    /**
     * Menampilkan daftar foto galeri publik.
     */
    public function galeriIndex()
    {
        $galeris = Galeri::active()->orderBy('urutan')->paginate(12); // Tampilkan yang aktif saja
        return view('public.galeri.index', compact('galeris'));
    }

    /**
     * Menampilkan detail foto galeri publik.
     *
     * @param  \App\Models\Galeri  $galeri
     */
    public function galeriShow(Galeri $galeri)
    {
        if (!$galeri->is_active) {
            abort(404); // Jika tidak aktif, tampilkan 404
        }
        return view('public.galeri.show', compact('galeri'));
    }

    /**
     * Menampilkan daftar video edukasi publik.
     */
    public function videoIndex()
    {
        $videos = Video::active()->latest('created_at')->paginate(9); // Tampilkan yang aktif saja
        return view('public.video.index', compact('videos'));
    }

    /**
     * Menampilkan detail video edukasi publik dan menambah views count.
     *
     * @param  \App\Models\Video  $video
     */
    public function videoShow(Video $video)
    {
        if (!$video->is_active) {
            abort(404); // Jika tidak aktif, tampilkan 404
        }
        $video->incrementViews(); // Tambah views count setiap kali video dilihat
        return view('public.video.show', compact('video'));
    }

    /**
     * Menampilkan daftar artikel publik.
     */
    public function artikelIndex()
    {
        $artikels = Artikel::published()->latest('published_at')->paginate(10); // Hanya artikel yang published
        return view('public.artikel.index', compact('artikels'));
    }

    /**
     * Menampilkan detail artikel publik dan menambah views count.
     *
     * @param  \App\Models\Artikel  $artikel
     */
    public function artikelShow(Artikel $artikel)
    {
        // Pastikan artikel berstatus published sebelum ditampilkan
        if ($artikel->status !== 'published') {
            abort(404);
        }
        $artikel->incrementViews(); // Tambah views count setiap kali artikel dilihat
        return view('public.artikel.show', compact('artikel'));
    }
}