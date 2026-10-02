<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia, HasSlug;

    protected $fillable = ['title', 'slug', 'group', 'description', 'icon', 'published', 'order'];
    protected $casts = ['published' => 'boolean'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public const GROUPS = [
        'scale_models' => 'Architectural Scale Models',
        'visualizations' => '3D Visualizations',
    ];

    public function scopeInGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}