<?php

namespace App\Enums;

enum RegistrationStatus
{
    case pending;
    case confirmed;
    case cancelled;
}
