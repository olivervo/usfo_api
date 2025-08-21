<?php

namespace App\Spar\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SvenskAdress extends Data
{
    public function __construct(
        #[MapOutputName('validFrom')]
        public Carbon $DatumFrom,

        #[MapOutputName('validTo')]
        public Carbon $DatumTill,

        #[MapOutputName('careOf')]
        public string|Optional $CareOf,

        #[MapOutputName('address1')]
        public string|Optional $Utdelningsadress1,

        #[MapOutputName('address2')]
        public string|Optional $Utdelningsadress2,

        #[MapOutputName('zipCode')]
        public string $PostNr,

        #[MapOutputName('city')]
        public string $Postort,
    ) {}
}
