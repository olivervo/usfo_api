<?php

namespace App\Enums;

enum PaymentStatus
{
    case pending;
    case partially_refunded;
    case refunded;
    case paid;
}
