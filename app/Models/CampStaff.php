<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CampStaff extends Pivot
{
    use LogsActivity;

    public $incrementing = true;

    protected $casts = [
        'reminder_sent' => 'datetime',
        'status_updated_at' => 'datetime',
        'status' => AssignmentStatus::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->dontSubmitEmptyLogs();
    }

    public function camp(): BelongsTo
    {
        return $this->belongsTo(Camp::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function getTotalSalaryAttribute(): float|int
    {
        return $this->weekly_salary * $this->camp->weeks * $this->percent;
    }
}
