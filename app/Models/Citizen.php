<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'id_number',
        'birth_date',
        'gender',
        'phone_number',
        'address',
        'id_card_path',
        'selfie_path',
        'profile_picture',
        'status',
        'verified_at',
        'verified_by',
        'reject_reason'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'verified_at' => 'datetime',
        'verified_by' => 'integer',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'citizen_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}