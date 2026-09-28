<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProjectCategory extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'slug', 'color', 'description', 'order', 'published'];

    protected $casts = ['published' => 'boolean'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}