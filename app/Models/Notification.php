<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'recipient',
        'status',
        'data',
        'sent_at',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'sent_at' => 'datetime',
        ];
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'sent' => 'success',
            'failed' => 'danger'
        ];
        
        return $badges[$this->status] ?? 'secondary';
    }

    public function getIsSentAttribute()
    {
        return $this->status === 'sent';
    }

    public function getIsFailedAttribute()
    {
        return $this->status === 'failed';
    }

    // Methods
    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'error_message' => null
        ]);
    }

    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage
        ]);
    }

    public static function createWhatsAppNotification($phone, $title, $message, $data = [])
    {
        return static::create([
            'type' => 'whatsapp',
            'title' => $title,
            'message' => $message,
            'recipient' => $phone,
            'data' => $data,
            'status' => 'pending'
        ]);
    }

    public static function createEmailNotification($email, $title, $message, $data = [])
    {
        return static::create([
            'type' => 'email',
            'title' => $title,
            'message' => $message,
            'recipient' => $email,
            'data' => $data,
            'status' => 'pending'
        ]);
    }

    public static function createSystemNotification($title, $message, $data = [])
    {
        return static::create([
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'recipient' => 'system',
            'data' => $data,
            'status' => 'pending'
        ]);
    }
}