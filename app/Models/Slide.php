<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slide extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'subtitle', 'location', 'scale',
        'link_url', 'link_label', 'cta_type',
        'published', 'order',
    ];

    protected $casts = ['published' => 'boolean'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function getResolvedUrlAttribute(): ?string
    {
        return match ($this->cta_type) {
            'whatsapp' => 'https://wa.me/' . preg_replace('/\D/', '', \App\Models\Setting::get('contact.whatsapp', '')),
            'email'    => 'mailto:' . \App\Models\Setting::get('contact.email', ''),
            default    => $this->link_url,
        };
    }
}