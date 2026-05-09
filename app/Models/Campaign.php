<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Campaign extends Model
{
    protected $fillable = [
        'user_id', 
        'entity_id', 
        'category_id',
        'title', 
        'slug', 
        'description', 
        'is_urgent', 
        'goal_amount', 
        'current_amount',
        'donors_count',
        'start_at', 
        'end_at', 
        'status', 
        'is_active',
        'approved_at', 
        'approved_by',
        'rejection_reason'
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'is_active' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'approved_at' => 'datetime',
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    public function campaignCategory(): BelongsTo
    {
        return $this->belongsTo(CampaignCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CampaignImage::class, 'campaign_id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(CampaignImage::class, 'campaign_id')->where('is_primary', true);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'campaign_id');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(CampaignUpdate::class, 'campaign_id');
    }
}