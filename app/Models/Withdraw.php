<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'amount',
        'bank_name',
        'account_number',
        'account_holder',
        'status',
        'approved_at',
        'approved_by',
        'rejection_reason'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Admin approver
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
