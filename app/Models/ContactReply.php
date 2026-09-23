<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $fillable = [
        'contact_message_id', 'direction', 'body',
        'subject', 'read_by_admin', 'read_by_user', 'emailed_at',
    ];

    protected $casts = [
        'read_by_admin' => 'boolean',
        'read_by_user'  => 'boolean',
        'emailed_at'    => 'datetime',
    ];

    public function contactMessage()
    {
        return $this->belongsTo(ContactMessage::class);
    }

    public function scopeOutbound($query)
    {
        return $query->where('direction', 'outbound');
    }

    public function scopeInbound($query)
    {
        return $query->where('direction', 'inbound');
    }
}