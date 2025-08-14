<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BoatweekStaff extends Pivot
{
    use LogsActivity;

    public $incrementing = true;

    protected $casts = [
        'reminder_sent' => 'datetime',
        'status_updated_at' => 'datetime',
        'percent' => 'float',
        'weekly_salary' => 'integer',
        'status' => AssignmentStatus::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->dontSubmitEmptyLogs();
    }

    public function boatweek(): BelongsTo
    {
        return $this->belongsTo(Boatweek::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function getTotalSalaryAttribute(): float|int
    {
        return $this->weekly_salary * $this->percent;
    }
}
