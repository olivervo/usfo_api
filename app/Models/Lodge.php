<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lodge extends Model
{
    /** @use HasFactory<\Database\Factories\LodgeFactory> */
    use HasFactory;

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
