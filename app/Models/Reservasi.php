<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Reservasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_reservasi',
        'jadwal_workshop_id',
        'jenis_peserta',
        'jumlah_peserta',
        'nama_pemesan',
        'email_pemesan',
        'telepon_pemesan',
        'alamat_pemesan',
        'file_permohonan',
        'total_harga',
        'status_pembayaran',
        'midtrans_transaction_id',
        'midtrans_response',
        'paid_at',
        'reminder_sent',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_peserta' => 'integer',
            'total_harga' => 'decimal:2',
            'paid_at' => 'datetime',
            'reminder_sent' => 'boolean',
            'midtrans_response' => 'array',
        ];
    }

    // Relationships
    public function jadwalWorkshop()
    {
        return $this->belongsTo(JadwalWorkshop::class);
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('status_pembayaran', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status_pembayaran', 'pending');
    }

    public function scopeToday($query)
    {
        return $query->whereHas('jadwalWorkshop', function($q) {
            $q->whereDate('tanggal', today());
        });
    }

    public function scopeNeedReminder($query)
    {
        return $query->where('status_pembayaran', 'paid')
                    ->where('reminder_sent', false)
                    ->whereHas('jadwalWorkshop', function($q) {
                        $q->whereDate('tanggal', Carbon::tomorrow());
                    });
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'expired' => 'secondary'
        ];
        
        return $badges[$this->status_pembayaran] ?? 'secondary';
    }

    public function getIsPaidAttribute()
    {
        return $this->status_pembayaran === 'paid';
    }

    // Methods
    public static function generateNomorReservasi()
    {
        $prefix = 'RSV';
        $date = now()->format('ymd');
        $lastNumber = static::where('nomor_reservasi', 'like', $prefix . $date . '%')
                           ->latest('id')
                           ->first();
        
        if ($lastNumber) {
            $lastIncrement = intval(substr($lastNumber->nomor_reservasi, -3));
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
            if (empty($model->nomor_reservasi)) {
                $model->nomor_reservasi = static::generateNomorReservasi();
            }
        });
    }
}