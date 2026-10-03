<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrochureLead extends Model
{
    protected $fillable = [
        'brochure_id', 'name', 'email', 'phone', 'company', 'message',
        'ip_address', 'user_agent', 'emailed_at', 'is_read',
    ];

    protected $casts = [
        'emailed_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    public function brochure()
    {
        return $this->belongsTo(Brochure::class);
    }

    public function markAsRead(): void
    {
        if (! $this->is_read) {
            $this->update(['is_read' => true]);
        }
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}