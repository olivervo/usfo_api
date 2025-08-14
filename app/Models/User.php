<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Billable, HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected $appends = [
        'full_name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'stripe_id',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'stripe_id',
        'remember_token',
        'id_number',
        'password',
    ];

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'billable');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function stripeName(): string
    {
        return $this->full_name;
    }

    public function stripeAddress(): array
    {
        return [
            'city' => $this->city,
            'country' => $this->country,
            'line1' => $this->address,
            'postal_code' => $this->zipcode,
        ];
    }

    public function stripeMetadata()
    {
        return [
            'billable_id' => $this->id,
            'billable_type' => $this::class,
        ];
    }

    protected function casts(): array
    {
        return [

            'phone' => config('app.env') === 'production' ? (E164PhoneNumberCast::class) : 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
