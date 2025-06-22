<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_nota',
        'kasir_id',
        'nama_pembeli',
        'telepon_pembeli',
        'total_harga',
        'total_bayar',
        'kembalian',
        'tanggal_penjualan',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'decimal:2',
            'total_bayar' => 'decimal:2',
            'kembalian' => 'decimal:2',
            'tanggal_penjualan' => 'datetime',
        ];
    }

    // Relationships
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_penjualan', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_penjualan', now()->month)
                    ->whereYear('tanggal_penjualan', now()->year);
    }

    public function scopeByKasir($query, $kasirId)
    {
        return $query->where('kasir_id', $kasirId);
    }

    // Accessors
    public function getTotalItemAttribute()
    {
        return $this->detailPenjualans->sum('qty');
    }

    public function getTotalKeuntunganAttribute()
    {
        return $this->detailPenjualans->sum(function($detail) {
            return ($detail->harga_satuan - $detail->stockBatik->harga_beli) * $detail->qty;
        });
    }

    // Methods
    public static function generateNomorNota()
    {
        $prefix = 'NT';
        $date = now()->format('ymd');
        $lastNumber = static::where('nomor_nota', 'like', $prefix . $date . '%')
                           ->latest('id')
                           ->first();
        
        if ($lastNumber) {
            $lastIncrement = intval(substr($lastNumber->nomor_nota, -3));
            $newIncrement = str_pad($lastIncrement + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newIncrement = '001';
        }
        
        return $prefix . $date . $newIncrement;
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->nomor_nota)) {
                $model->nomor_nota = static::generateNomorNota();
            }
            if (empty($model->tanggal_penjualan)) {
                $model->tanggal_penjualan = now();
            }
        });
    }
}