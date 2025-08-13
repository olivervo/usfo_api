<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Personnummer\Personnummer;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Staff extends Model
{
    /** @use HasFactory<\Database\Factories\StaffFactory> */
    use HasFactory, LogsActivity;

    protected $appends = [
        'membership_status',
        'staff_avatar',
    ];

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->dontSubmitEmptyLogs();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function camps(): BelongsToMany
    {
        return $this->belongsToMany(Camp::class)->withPivot(
            'role',
            'status',
            'reminder_sent',
            'status_updated_at',
            'percent',
            'weekly_salary'
        )->using(CampStaff::class)->withTimestamps();
    }

    public function memberships(): MorphMany
    {
        return $this->morphMany(Membership::class, 'memberable');
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'billable');
    }

    public function boatweeks(): BelongsToMany
    {
        return $this->belongsToMany(Boatweek::class)->withPivot(
            'role',
            'status',
            'reminder_sent',
            'status_updated_at',
            'percent',
            'weekly_salary'
        )->using(BoatweekStaff::class)->withTimestamps();
    }

    public function boatweekAssignments(): HasMany
    {
        return $this->hasMany(BoatweekStaff::class);
    }

    public function campAssignments(): HasMany
    {
        return $this->hasMany(CampStaff::class);
    }

    public function getStaffAvatarAttribute(): string
    {
        if ($this->avatar) {
            return url('/storage/' . $this->avatar);
        } else {
            return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '?s=400' . '&default=https%3A%2F%2Fui-avatars.com%2Fapi%2F/' . $this->first_name . '+' . $this->last_name . '/400' . '/daecfd';
        }
    }

    public function getRegistryStatusAttribute(): bool
    {
        if ($this->registry_checked_at?->year >= DateService::getCurrentYear() - 1) {
            return true;
        } else {
            return false;
        }
    }

    public function scopeValidRegistry($query): void
    {
        $query->whereYear('registry_checked_at', '>=', DateService::getCurrentYear() - 1);
    }

    public function scopeInvalidRegistry($query): void
    {
        $query->whereYear('registry_checked_at', '<', DateService::getCurrentYear() - 1);
    }

    public function setCountryAttribute($value): void
    {
        $this->attributes['country'] = strtoupper($value);
    }

    public function getPNR(): string
    {
        if (Personnummer::valid($this->DOB)) {
            $pnr = Personnummer::parse($this->DOB);
            $year = $pnr->fullYear;
            $month = $pnr->month;
            $day = $pnr->day;

            return $year . $month . $day . '-XXXX';
        }

        return 'Ogiltigt personnummer';
    }

    public function getBirthdayAttribute(): string
    {
        if (Personnummer::valid($this->DOB ?? '')) {
            $PNR = Personnummer::parse($this->DOB);
            $DOB = $PNR->fullYear . '-' . $PNR->month . '-' . $PNR->day;
        } else {
            $DOB = $this->DOB;
        }

        return $DOB;
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getMembershipStatusAttribute(): string
    {
        $current_membership = $this->memberships->where('year', DateService::getCurrentYear())->first();

        return $current_membership?->status;
    }

    public function scopeValid($query): void
    {
        $query->whereHas('memberships', function (Builder $query) {
            $query->valid();
        });
    }

    public function scopeInvalid($query): void
    {
        $query->whereHas('memberships', function (Builder $query) {
            $query->invalid();
        });
    }

    protected function casts(): array
    {
        return [
            'registry_checked_at' => 'date',
            'membership_status' => PaymentStatus::class,
        ];
    }
}
