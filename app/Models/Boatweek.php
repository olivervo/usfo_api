<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Boatweek extends Model
{
    /** @use HasFactory<\Database\Factories\BoatweekFactory> */
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->dontSubmitEmptyLogs();
    }

    public function sc(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)->wherePivot('role', 'sc')->wherePivot('status', AssignmentStatus::confirmed);
    }

    public function bc(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)->wherePivot('role', 'bc')->wherePivot('status', AssignmentStatus::confirmed);
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Staff::class)->withPivot('role', 'status', 'reminder_sent', 'status_updated_at', 'percent', 'weekly_salary')->using(BoatweekStaff::class)->withTimestamps();
    }

    public function boatweekAssignments(): HasMany
    {
        return $this->hasMany(BoatweekStaff::class);
    }

    public function getNameAttribute(): string
    {
        return 'VG Båt/Mat v.' . $this->week_number . ' (' . $this->year . ')';
    }

    public function scopeCurrent($query)
    {
        return $query->where('year', DateService::getCurrentYear());
    }
}
