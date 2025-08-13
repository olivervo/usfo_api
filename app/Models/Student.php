<?php

namespace App\Models;

use App\Services\DateService;
use App\Traits\MaskAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, LogsActivity, MaskAttributes;

    protected $guarded = [];

    protected $hidden = [
        'id_number',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->dontSubmitEmptyLogs();
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function memberships(): MorphMany
    {
        return $this->morphMany(Membership::class, 'memberable');
    }

    public function hasValidMembership(?int $year): bool
    {
        $year ??= DateService::getCurrentYear();

        return $this->memberships?->active()
            ->whereYear($year)
            ->exists();
    }

    protected function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }
}
