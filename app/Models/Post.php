<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'post_category_id', 'title', 'slug', 'excerpt', 'body',
        'tags', 'featured', 'published', 'published_at', 'order',
    ];

    protected $casts = [
        'tags' => 'array',
        'featured' => 'boolean',
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero')->singleFile();
        $this->addMediaCollection('gallery');

        $this->addMediaConversion('thumb')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->nonQueued();
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->body));
        return max(1, (int) ceil($words / 200));
    }


    public function category()
{
    return $this->belongsTo(PostCategory::class, 'post_category_id');
}
}