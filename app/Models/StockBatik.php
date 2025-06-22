<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pengrajin; // Import Pengrajin model
use Carbon\Carbon; // Tambahkan ini

class StockBatik extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_batik',
        'pengrajin_id',
        'nama_batik',
        'deskripsi',
        'motif',
        'ukuran',
        'harga_beli',
        'harga_jual',
        'qty_masuk',
        'qty_tersedia',
        'qty_terjual',
        'qr_code',
        'tanggal_masuk',
    ];

    protected function casts(): array
    {
        return [
            'harga_beli' => 'decimal:2',
            'harga_jual' => 'decimal:2',
            'qty_masuk' => 'integer',
            'qty_tersedia' => 'integer',
            'qty_terjual' => 'integer',
            'tanggal_masuk' => 'date', // Ini akan meng-cast ke objek Carbon
        ];
    }

    // Relationships
    public function pengrajin()
    {
        return $this->belongsTo(Pengrajin::class);
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('qty_tersedia', '>', 0);
    }

    public function scopeLowStock($query, $minimum = 5)
    {
        return $query->where('qty_tersedia', '<=', $minimum)
                     ->where('qty_tersedia', '>', 0);
    }

    // Accessors
    public function getMarginAttribute()
    {
        return $this->harga_jual - $this->harga_beli;
    }

    public function getMarginPersentaseAttribute()
    {
        if ($this->harga_beli == 0) return 0;
        return round(($this->margin / $this->harga_beli) * 100, 2);
    }

    public function getNilaiStockAttribute()
    {
        return $this->qty_tersedia * $this->harga_jual;
    }

    public function getIsLowStockAttribute()
    {
        return $this->qty_tersedia <= 5 && $this->qty_tersedia > 0;
    }

    // Methods
    public static function generateKodeBatik($pengrajinId, $tanggalMasuk = null)
    {
        $pengrajin = Pengrajin::find($pengrajinId);
        if (!$pengrajin) {
            // Handle jika pengrajin tidak ditemukan, ini seharusnya dicegah oleh validasi Request
            Log::error("Pengrajin dengan ID {$pengrajinId} tidak ditemukan saat generateKodeBatik.");
            return null; // Atau throw exception
        }

        // Perbaikan di sini: Pastikan $tanggal diformat menjadi YMD (6 digit)
        // Jika $tanggalMasuk sudah objek Carbon (karena 'date' cast), langsung format.
        // Jika $tanggalMasuk masih string, parse dulu baru format.
        $tanggal = ($tanggalMasuk instanceof Carbon) ? $tanggalMasuk->format('ymd') : Carbon::parse($tanggalMasuk)->format('ymd');

        $prefix = $pengrajin->kode_pengrajin . $tanggal; // Ini akan menjadi 4 + 6 = 10 karakter

        // Cari kode batik yang paling baru dengan prefix yang sama
        $lastNumber = static::where('kode_batik', 'like', $prefix . '%')
                             ->orderBy('kode_batik', 'desc') // Urutkan kode_batik secara menurun
                             ->first();

        $newIncrement = '01'; // Default increment

        if ($lastNumber) {
            // Ambil 2 digit terakhir dari kode_batik yang sudah ada
            $lastIncrement = intval(substr($lastNumber->kode_batik, -2));
            $newIncrement = str_pad($lastIncrement + 1, 2, '0', STR_PAD_LEFT);
        }

        return $prefix . $newIncrement; // Total panjang: 10 + 2 = 12 karakter. Ini muat di string(15)!
    }

    public function kurangiStock($qty)
    {
        if ($this->qty_tersedia >= $qty) {
            $this->decrement('qty_tersedia', $qty);
            $this->increment('qty_terjual', $qty);
            return true;
        }
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Hanya generate kode jika belum ada (misal diisi manual dari seeder)
            if (empty($model->kode_batik)) {
                $model->kode_batik = static::generateKodeBatik($model->pengrajin_id, $model->tanggal_masuk);
            }

            // Set qty_tersedia jika belum diatur (pastikan ini dilakukan setelah qty_masuk ada)
            if (!isset($model->qty_tersedia)) {
                $model->qty_tersedia = $model->qty_masuk;
            }
            // Pastikan qty_terjual default 0 jika belum diatur
            if (!isset($model->qty_terjual)) {
                $model->qty_terjual = 0;
            }
        });
    }
}