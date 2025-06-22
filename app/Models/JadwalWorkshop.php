<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class JadwalWorkshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_workshop_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'max_peserta',
        'peserta_terdaftar',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jam_mulai' => 'datetime:H:i',
            'jam_selesai' => 'datetime:H:i',
            'max_peserta' => 'integer',
            'peserta_terdaftar' => 'integer',
        ];
    }

    // Relationships
    public function paketWorkshop()
    {
        return $this->belongsTo(PaketWorkshop::class);
    }

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                     ->where('tanggal', '>=', now()->toDateString());
    }

    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>', now()->toDateString())
                     ->orderBy('tanggal')
                     ->orderBy('jam_mulai');
    }

    // Accessors & Mutators
    public function getSlotTersisaAttribute()
    {
        return $this->max_peserta - $this->peserta_terdaftar;
    }

    public function getIsFullAttribute()
    {
        return $this->peserta_terdaftar >= $this->max_peserta;
    }

    // Accessor yang ini sudah ada, tapi dia tidak menggabungkan jam dari kolom berbeda.
    // public function getJadwalLengkapAttribute()
    // {
    //     return Carbon::parse($this->tanggal)->format('d/m/Y') . ' ' .
    //            Carbon::parse($this->jam_mulai)->format('H:i') . ' - ' .
    //            Carbon::parse($this->jam_selesai)->format('H:i');
    // }

    // Tambahkan Accessor baru ini untuk menampilkan tanggal dan jam secara bersamaan
    public function getWaktuLengkapAttribute()
    {
        // Pastikan 'tanggal' adalah instance Carbon karena sudah di-cast
        $tanggalFormatted = $this->tanggal->format('d M Y');

        // Pastikan 'jam_mulai' dan 'jam_selesai' adalah instance Carbon karena sudah di-cast
        $jamMulaiFormatted = $this->jam_mulai ? $this->jam_mulai->format('H:i') : '00:00';
        $jamSelesaiFormatted = $this->jam_selesai ? $this->jam_selesai->format('H:i') : '00:00';

        return "{$tanggalFormatted} ({$jamMulaiFormatted} - {$jamSelesaiFormatted})";
    }


    // Methods
    public function updatePesertaTerdaftar()
    {
        $total = $this->reservasis()->where('status_pembayaran', 'paid')->sum('jumlah_peserta');
        $this->update(['peserta_terdaftar' => $total]);

        if ($total >= $this->max_peserta) {
            $this->update(['status' => 'full']);
        }
        // Tambahan: jika tadinya full tapi sekarang tidak, kembalikan ke available
        elseif ($this->status === 'full' && $total < $this->max_peserta) {
            $this->update(['status' => 'available']);
        }
    }
}