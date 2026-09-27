<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question', 'answer', 'category',
        'featured', 'published', 'order',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'published' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * All distinct category keys used in the table.
     */
    public static function categories(): array
    {
        return [
            'general'   => 'General',
            'pricing'   => 'Pricing & Quotations',
            'process'   => 'Process & Timelines',
            'materials' => 'Materials & Craft',
            'delivery'  => 'Delivery & Installation',
            'support'   => 'After-Sales Support',
        ];
    }
}