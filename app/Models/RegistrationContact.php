<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'name',
        'phone',
        'email',
        'is_primary',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
