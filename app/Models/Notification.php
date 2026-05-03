<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'link',
        'read_at'
    ];

    /**
     * Casting read_at menjadi objek Carbon/Datetime
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Relasi ke User (Pemilik notifikasi)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk mengambil notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}