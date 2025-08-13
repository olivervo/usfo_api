<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use App\Enums\Sex;
use App\Services\DateService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Personnummer\Personnummer;
use Personnummer\PersonnummerException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Registration extends Model
{
    /** @use HasFactory<Registration> */
    use HasFactory, LogsActivity, MassPrunable, Notifiable;

    protected $guarded = ['paid_complete', 'deposit_paid_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function camp(): BelongsTo
    {
        return $this->belongsTo(Camp::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function deposit(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(RegistrationContact::class);
    }

    public function primaryContact(): HasOne
    {
        return $this->contacts()->where('is_primary', true)->one();
    }

    public function extraContacts(): HasMany
    {
        return $this->contacts()->where('is_primary', false);
    }

    public function getBirthdayAttribute(): string
    {
        try {
            $PNR = Personnummer::parse($this->DOB);
            $DOB = $PNR->fullYear . '-' . $PNR->month . '-' . $PNR->day;
        } catch (PersonnummerException $e) {
            $DOB = $this->DOB;
        }

        return $DOB;
    }

    public function routeNotificationForSns($notification): ?string
    {
        return $this->telephone;
    }

    public function scopeActive($query): void
    {
        $query->where('status', 'active')->orWhere('created_at', '>=', now()->subMinutes(10));
    }

    public function scopeCurrent($query): void
    {
        $current_year = DateService::getCurrentYear();
        $query->whereHas('camp', function (Builder $query) use ($current_year) {
            $query->where('year', $current_year);
        });
    }

    public function scopeOutstanding($query): void
    {
        $query->whereNull('paid_complete');
    }

    public function scopeSettled($query): void
    {
        $query->whereNotNull('paid_complete');
    }

    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subHours(24))
            ->where('status', 'pending');
    }

    protected function casts(): array
    {
        return [
            'refunded_at' => 'datetime',
            'paid_complete' => 'datetime',
            'invoice_sent_at' => 'datetime',
            'status' => RegistrationStatus::class,
            'sex' => Sex::class,
            'date_of_birth' => 'date',
        ];
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucfirst($value),
        );
    }

    protected function address(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucfirst($value),
        );
    }

    protected function city(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucfirst($value),
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
        );
    }
}
