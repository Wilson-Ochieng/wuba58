<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ContactMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'token', 'name', 'email', 'phone', 'company', 'project_type',
        'message', 'ip_address', 'user_agent',
        'is_read', 'read_at', 'last_activity_at',
    ];

    protected $casts = [
        'is_read'          => 'boolean',
        'read_at'          => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $msg) {
            if (empty($msg->token)) {
                $msg->token = Str::random(48);
            }
        });
    }

    public function replies()
    {
        return $this->hasMany(ContactReply::class)->orderBy('created_at');
    }

    public function markAsRead(): void
    {
        if (! $this->is_read) {
            $this->update(['is_read' => true, 'read_at' => now()]);
        }
    }

    public function touchActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }

    public function unreadRepliesCount(): int
    {
        return $this->replies()->where('direction', 'inbound')->where('read_by_admin', false)->count();
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

   public function getReplyUrlAttribute(): string
{
    if (empty($this->token)) {
        $this->update(['token' => \Illuminate\Support\Str::random(48)]);
    }
    return route('contact.thread', $this->token);
}
}