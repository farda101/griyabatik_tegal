<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'old_data' => 'array',
            'new_data' => 'array',
            'model_id' => 'integer',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByModel($query, $model)
    {
        return $query->where('model', $model);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // Accessors
    public function getActionBadgeAttribute()
    {
        $badges = [
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            'login' => 'info',
            'logout' => 'secondary',
            'view' => 'light'
        ];
        
        return $badges[$this->action] ?? 'primary';
    }

    public function getModelNameAttribute()
    {
        $modelNames = [
            'StockBatik' => 'Stock Batik',
            'StockBahan' => 'Stock Bahan',
            'Penjualan' => 'Penjualan',
            'Reservasi' => 'Reservasi',
            'User' => 'User',
            'Pengrajin' => 'Pengrajin',
            'PaketWorkshop' => 'Paket Workshop',
            'JadwalWorkshop' => 'Jadwal Workshop',
            'Artikel' => 'Artikel',
            'Galeri' => 'Galeri',
            'Video' => 'Video'
        ];

        return $modelNames[$this->model] ?? $this->model;
    }

    // Methods
    public static function logActivity($user, $action, $model, $modelId = null, $oldData = null, $newData = null)
    {
        return static::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function logLogin($user)
    {
        return static::logActivity($user, 'login', 'User', $user->id);
    }

    public static function logLogout($user)
    {
        return static::logActivity($user, 'logout', 'User', $user->id);
    }

    public static function logCreate($user, $model, $modelId, $data)
    {
        return static::logActivity($user, 'create', $model, $modelId, null, $data);
    }

    public static function logUpdate($user, $model, $modelId, $oldData, $newData)
    {
        return static::logActivity($user, 'update', $model, $modelId, $oldData, $newData);
    }

    public static function logDelete($user, $model, $modelId, $data)
    {
        return static::logActivity($user, 'delete', $model, $modelId, $data, null);
    }

    public static function logView($user, $model, $modelId)
    {
        return static::logActivity($user, 'view', $model, $modelId);
    }
}