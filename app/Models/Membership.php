<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Membership extends Model
{
    /** @use HasFactory<\Database\Factories\MembershipFactory> */
    use HasFactory, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->dontSubmitEmptyLogs();
    }

    public function scopeActive($query): void
    {
        $query->where('status', 'active');
    }

    public function memberable(): MorphTo
    {
        return $this->morphTo();
    }

    public function whereYear(int $year): Builder
    {
        return $this->where('membership_year', $year);
    }

    public function activate(?Payment $payment = null): void
    {
        $this->update([
            'status' => 'active',
            'payment_id' => $payment?->id,
            'paid_at' => $payment?->paid_at ?? now(),
        ]);
    }

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'refunded_at' => 'datetime',
            'status' => PaymentStatus::class,
        ];
    }
}
