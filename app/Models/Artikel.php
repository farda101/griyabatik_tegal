<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'excerpt',
        'featured_image',
        'status',
        'views_count',
        'author_id',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    // Accessors
    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/articles/' . $this->featured_image) : null;
    }

    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->konten), 160);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->konten));
        $readingTime = ceil($wordCount / 200); // Average 200 words per minute
        return $readingTime . ' menit baca';
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
            if ($model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('judul') && empty($model->getOriginal('slug'))) {
                $model->slug = Str::slug($model->judul);
            }
            if ($model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
        });
    }
}