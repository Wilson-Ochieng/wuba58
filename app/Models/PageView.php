<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'path', 'route_name', 'referrer', 'user_agent', 'device_type',
        'country', 'city', 'ip_hash', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Detect device type from a user agent string.
     */
    public static function detectDevice(?string $ua): string
    {
        if (! $ua) return 'unknown';
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) return 'tablet';
        if (preg_match('/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated/i', $ua)) return 'mobile';
        return 'desktop';
    }

    public static function detectBrowser(?string $ua): string
    {
        if (! $ua) return 'unknown';
        if (str_contains($ua, 'Edg')) return 'Edge';
        if (str_contains($ua, 'Chrome') && ! str_contains($ua, 'Chromium')) return 'Chrome';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Safari') && ! str_contains($ua, 'Chrome')) return 'Safari';
        return 'Other';
    }
}