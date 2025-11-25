<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketWorkshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga_individu',
        'harga_kelompok',
        'durasi_menit',
        'max_peserta',
        'min_participants',
        'max_participants',
        'duration_days',
        'max_reservation_days',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'harga_individu' => 'decimal:2',
            'harga_kelompok' => 'decimal:2',
            'durasi_menit' => 'integer',
            'max_peserta' => 'integer',
            'min_participants' => 'integer',
            'max_participants' => 'integer',
            'duration_days' => 'integer',
            'max_reservation_days' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function jadwalWorkshops()
    {
        return $this->hasMany(JadwalWorkshop::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getDurasiJamAttribute()
    {
        return round($this->durasi_menit / 60, 2);
    }

    public function getHargaByJenisAttribute()
    {
        return function($jenis) {
            return $jenis === 'individu' ? $this->harga_individu : $this->harga_kelompok;
        };
    }
}