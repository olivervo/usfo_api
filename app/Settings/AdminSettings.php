<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AdminSettings extends Settings
{
    public string $export_password;

    public static function group(): string
    {
        return 'admin';
    }
}
