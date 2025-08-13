<?php

namespace App\Spar\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Folkbokforingsadress extends Data
{
    public function __construct(
        public SvenskAdress $SvenskAdress,
        /* public Carbon $DatumFrom,
        public Carbon $DatumTill,
        public string|Optional $CareOf,
        public string|Optional $Utdelningsadress1,
        public string|Optional $Utdelningsadress2,
        public string $PostNr,
        public string $Postort, */
    ) {}
}
