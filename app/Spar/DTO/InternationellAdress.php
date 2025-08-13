<?php

namespace App\Spar\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class InternationellAdress extends Data
{
    public function __construct(
        public Carbon $DatumFrom,
        public Carbon $DatumTill,
        public string|Optional $Utdelningsadress1,
        public string|Optional $Utdelningsadress2,
        public string|Optional $Utdelningsadress3,
        public string $Land,
    ) {}
}
