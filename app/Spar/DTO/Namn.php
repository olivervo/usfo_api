<?php

namespace App\Spar\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Namn extends Data
{
    public function __construct(
        public Carbon $DatumFrom,
        public Carbon $DatumTill,
        public string|Optional $Fornamn,
        public string|Optional $Mellannamn,
        public string|Optional $Efternamn,
        public string|Optional $Tilltalsnamn,
    ) {}
}
