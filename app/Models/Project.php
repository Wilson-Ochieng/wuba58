<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Project extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title', 'slug', 'location', 'category', 'scale',
        'client_name', 'year', 'excerpt', 'description',
        'featured', 'published', 'order', 'published_at',
    ];

    protected $casts = [
        'featured'     => 'boolean',
        'published'    => 'boolean',
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
        $this->addMediaCollection('process');
        $this->addMediaCollection('before')->singleFile();
        $this->addMediaCollection('after')->singleFile();
        $this->addMediaCollection('video')->singleFile();
        $this->addMediaCollection('model')->singleFile();
        $this->addMediaCollection('panorama');

        // Thumbnail conversion for hero
        $this->addMediaConversion('thumb')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->nonQueued();
    }

    public function hotspots()
    {
        return $this->hasMany(ModelHotspot::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}