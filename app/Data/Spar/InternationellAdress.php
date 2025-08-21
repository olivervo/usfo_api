<?php

namespace App\Data\Spar;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class InternationellAdress extends Data
{
    public function __construct(
        #[MapOutputName('validFrom')]
        public Carbon $DatumFrom,

        #[MapOutputName('validTo')]
        public Carbon $DatumTill,

        #[MapOutputName('address1')]
        public string|Optional $Utdelningsadress1,

        #[MapOutputName('address2')]
        public string|Optional $Utdelningsadress2,

        #[MapOutputName('address3')]
        public string|Optional $Utdelningsadress3,

        #[MapOutputName('country')]
        public string $Land,
    ) {}
}
