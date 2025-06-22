<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon; // Tambahkan ini jika belum ada

class StockBahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_bahan',
        'nama_bahan',
        'satuan',
        'harga_satuan',
        'qty_masuk',
        'qty_tersedia', // Pastikan ini ada di $fillable
        'qty_terpakai', // Pastikan ini ada di $fillable
        'total_harga',
        'qr_code',
        'tanggal_masuk',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'harga_satuan' => 'decimal:2',
            'qty_masuk' => 'integer',
            'qty_tersedia' => 'integer',
            'qty_terpakai' => 'integer',
            'total_harga' => 'decimal:2',
            'tanggal_masuk' => 'date',
        ];
    }

    // Relationships
    public function penggunaanBahans()
    {
        return $this->hasMany(PenggunaanBahan::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('qty_tersedia', '>', 0);
    }

    public function scopeLowStock($query, $minimum = 10)
    {
        return $query->where('qty_tersedia', '<=', $minimum)
                     ->where('qty_tersedia', '>', 0);
    }

    // Accessors
    public function getNilaiStockAttribute()
    {
        return $this->qty_tersedia * $this->harga_satuan;
    }

    public function getIsLowStockAttribute()
    {
        return $this->qty_tersedia <= Setting::get('min_stock_alert_bahan', 10) && $this->qty_tersedia > 0;
    }

    // Methods
    public static function generateKodeBahan()
    {
        // Cari kode bahan terakhir untuk menentukan urutan berikutnya
        $lastNumber = static::latest('id')->first();
        
        $newIncrement = '001'; // Default jika belum ada data

        if ($lastNumber) {
            // Asumsi kode_bahan adalah string angka seperti "001", "002"
            $lastIncrement = intval($lastNumber->kode_bahan);
            $newIncrement = str_pad($lastIncrement + 1, 3, '0', STR_PAD_LEFT);
        }
        
        return $newIncrement;
    }

    public function kurangiBahan($qty)
    {
        if ($this->qty_tersedia >= $qty) {
            $this->decrement('qty_tersedia', $qty);
            $this->increment('qty_terpakai', $qty);
            return true;
        }
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Hanya generate kode jika belum ada (misal diisi manual dari seeder)
            if (empty($model->kode_bahan)) {
                $model->kode_bahan = static::generateKodeBahan();
            }
            
            // Perbaikan di sini: Pastikan qty_tersedia dan qty_terpakai diisi
            if (!isset($model->qty_tersedia)) {
                $model->qty_tersedia = $model->qty_masuk; // Qty tersedia = qty masuk awal
            }
            if (!isset($model->qty_terpakai)) {
                $model->qty_terpakai = 0; // Qty terpakai awal selalu 0
            }

            // total_harga dihitung berdasarkan qty_masuk dan harga_satuan
            // Pastikan qty_masuk dan harga_satuan sudah ada di model sebelum perhitungan
            $model->total_harga = $model->qty_masuk * $model->harga_satuan;
        });
    }
}