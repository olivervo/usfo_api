<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Camp extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'publish_at' => 'datetime',
    ];

    // Append accessors
    protected $appends = [
        'name',
        'free_males',
        'free_females',
        'total_spaces',
        'is_available',
        'availability',
    ];

    protected $withCount = [
        'males',
        'females',
        'activeRegistrations',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->dontSubmitEmptyLogs();
    }

    #[Scope]
    public function published(Builder $query): void
    {
        $query->where('start_date', '>', today())
            ->whereNull('registration_code')
            ->where(function ($query) {
                $query->where('publish_at', '<=', now())
                    ->orWhereNull('publish_at');
            });
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->start_date > today() && is_null($this->registration_code) && ($this->publish_at <= now() || is_null($this->publish_at));
    }

    #[Scope]
    public function current(Builder $query): void
    {
        $query->where('year', DateService::getCurrentYear());
    }

    #[Scope]
    public function future(Builder $query): void
    {
        $query->where('year', '>=', DateService::getCurrentYear());
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }

    public function females(): HasMany
    {
        return $this->hasMany(Registration::class)
            ->where('sex', 'female')
            ->active();
    }

    public function males(): HasMany
    {
        return $this->hasMany(Registration::class)
            ->where('sex', 'male')
            ->active();
    }

    public function kc(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)
            ->wherePivot('role', 'kc')
            ->wherePivot('status', AssignmentStatus::confirmed);
    }

    public function bkc(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)
            ->wherePivot('role', 'bkc')
            ->wherePivot('status', AssignmentStatus::confirmed);
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)
            ->withPivot(
                'role',
                'status',
                'reminder_sent',
                'status_updated_at',
                'percent',
                'weekly_salary'
            )->using(CampStaff::class)
            ->withTimestamps();
    }

    public function getNameAttribute(): string
    {
        return $this->camp_name . ' (' . $this->year . ')';
    }

    public function getTotalSpacesAttribute(): int
    {
        return $this->number_females + $this->number_males;
    }

    public function getTotalRegistrationsAttribute(): int
    {
        return $this->active_registrations_count;
    }

    public function activeRegistrations(): HasMany
    {
        return $this->hasMany(Registration::class)->active();
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->getFreeMalesAttribute() + $this->getFreeFemalesAttribute() > 0;
    }

    public function getFreeMalesAttribute(): int
    {
        $males = $this->number_males - $this->males_count;
        $females = $this->number_females - $this->females_count;

        if ($males <= 0) {
            return 0;
        } elseif ($this->availability <= 0) {
            return 0;
        } elseif ($females < 0) {
            return $males + $females;
        } else {
            return $males;
        }
    }

    public function getFreeFemalesAttribute(): int
    {
        $males = $this->number_males - $this->males_count;
        $females = $this->number_females - $this->females_count;

        if ($females <= 0) {
            return 0;
        } elseif ($this->availability <= 0) {
            return 0;
        } elseif ($males < 0) {
            return $males + $females;
        } else {
            return $females;
        }
    }

    public function getAvailabilityAttribute(): int
    {
        return $this->total_spaces - $this->total_registrations;
    }
}
