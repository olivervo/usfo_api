<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PublicSettings extends Settings
{
    public int $membership_fee;

    public int $registration_fee;

    public ?string $camps_message;

    public ?string $registration_confirmed_message;

    public static function group(): string
    {
        return 'public';
    }
}
