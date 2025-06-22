<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Pengrajin extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pengrajin',
        'nama_pengrajin',
        'alamat',
        'telepon',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function stockBatiks()
    {
        return $this->hasMany(StockBatik::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getTotalStockAttribute()
    {
        return $this->stockBatiks()->sum('qty_tersedia');
    }

    public function getTotalNilaiStockAttribute()
    {
        return $this->stockBatiks()->sum(DB::raw('qty_tersedia * harga_jual'));
    }
}