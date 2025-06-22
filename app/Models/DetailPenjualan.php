<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id',
        'stock_batik_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'harga_satuan' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    // Relationships
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function stockBatik()
    {
        return $this->belongsTo(StockBatik::class);
    }

    // Accessors
    public function getKeuntunganAttribute()
    {
        return ($this->harga_satuan - $this->stockBatik->harga_beli) * $this->qty;
    }

    public function getMarginPersentaseAttribute()
    {
        if ($this->stockBatik->harga_beli == 0) return 0;
        return round((($this->harga_satuan - $this->stockBatik->harga_beli) / $this->stockBatik->harga_beli) * 100, 2);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->subtotal = $model->qty * $model->harga_satuan;
        });

        static::updating(function ($model) {
            $model->subtotal = $model->qty * $model->harga_satuan;
        });
    }
}