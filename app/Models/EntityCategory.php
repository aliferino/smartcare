<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntityCategory extends Model
{
    protected $fillable = ['name'];

    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'entity_category_id');
    }
}