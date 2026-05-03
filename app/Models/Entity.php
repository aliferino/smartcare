<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    protected $fillable = [
        'user_id', 
        'entity_category_id',
        'name', 
        'slug', // Tambahkan ini
        'email', 
        'address', 
        'logo_path', 
        'legal_document_path', 
        'status',
        'is_active', // Tambahkan ini
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EntityCategory::class, 'entity_category_id');
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'entity_id');
    }
}