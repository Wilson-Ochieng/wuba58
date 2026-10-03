<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Brochure extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title', 'slug', 'description', 'category',
        'published', 'order', 'download_count',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);

        $this->addMediaCollection('cover')->singleFile();
    }

    public function leads()
    {
        return $this->hasMany(BrochureLead::class);
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->hasMedia('file') ? $this->getFirstMediaUrl('file') : null;
    }

    public function getFileSizeAttribute(): ?string
    {
        if (! $this->hasMedia('file')) {
            return null;
        }
        $bytes = $this->getFirstMedia('file')->size;
        return round($bytes / 1024 / 1024, 1) . ' MB';
    }
}