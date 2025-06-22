<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenggunaanBahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_bahan_id',
        'qty_digunakan',
        'keperluan',
        'keterangan',
        'tanggal_penggunaan',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'qty_digunakan' => 'integer',
            'tanggal_penggunaan' => 'date',
        ];
    }

    // Relationships
    public function stockBahan()
    {
        return $this->belongsTo(StockBahan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_penggunaan', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_penggunaan', now()->month)
                    ->whereYear('tanggal_penggunaan', now()->year);
    }

    // Accessors
    public function getNilaiPenggunaanAttribute()
    {
        return $this->qty_digunakan * $this->stockBahan->harga_satuan;
    }
}