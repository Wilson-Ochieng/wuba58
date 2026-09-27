<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_name', 'author_role', 'author_company', 'author_avatar_url',
        'body', 'rating', 'source', 'source_url', 'external_id',
        'reviewed_at', 'featured', 'published', 'order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'featured' => 'boolean',
        'published' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeFromGoogle($query)
    {
        return $query->where('source', 'google');
    }

    public function getInitialsAttribute(): string
    {
        $parts = preg_split('/\s+/', trim($this->author_name));
        $initials = '';
        foreach (array_slice($parts, 0, 2) as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }
        return $initials ?: '?';
    }
}