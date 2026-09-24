<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TourScene extends Model implements HasMedia
{
    use InteractsWithMedia, HasSlug;

    protected $fillable = [
        'project_id',
        'name',
        'slug',
        'description',
        'initial_yaw',
        'initial_pitch',
        'initial_hfov',
        'is_start',
        'order',
    ];

    protected $casts = [
        'is_start' => 'boolean',
        'initial_yaw' => 'float',
        'initial_pitch' => 'float',
        'initial_hfov' => 'float',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('panorama')->singleFile();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function hotspots()
    {
        return $this->hasMany(TourHotspot::class);
    }

    public function targetHotspots()
    {
        return $this->hasMany(TourHotspot::class, 'target_scene_id');
    }
}