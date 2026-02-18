<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_url',
        'category_id',
        'author_id',
        'published_date',
        'is_published',
        'read_time',
    ];

    protected $casts = [
        'published_date' => 'datetime',
        'is_published' => 'boolean',
        'read_time' => 'integer',
    ];

    protected $dates = [
        'published_date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug);
        });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_date', 'desc');
    }

    public function getFormattedDateAttribute()
    {
        return $this->published_date->format('d F Y');
    }

    public function getReadingTimeAttribute()
    {
        return $this->read_time . ' min';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }
}
