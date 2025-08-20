<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case pending = 'pending';
    case confirmed = 'confirmed';
    case cancelled = 'cancelled';
}
