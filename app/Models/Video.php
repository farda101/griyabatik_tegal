<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_video',
        'thumbnail',
        'durasi_detik',
        'views_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'durasi_detik' => 'integer',
            'views_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    // Accessors
    public function getVideoUrlAttribute()
    {
        return asset('storage/videos/' . $this->file_video);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/thumbnails/' . $this->thumbnail) : null;
    }

    public function getDurasiFormatAttribute()
    {
        $menit = floor($this->durasi_detik / 60);
        $detik = $this->durasi_detik % 60;
        return sprintf('%02d:%02d', $menit, $detik);
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}