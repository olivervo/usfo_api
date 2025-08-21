<?php

namespace App\Data\Spar;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class Namn extends Data
{
    public function __construct(
        #[MapOutputName('validFrom')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $DatumFrom,

        #[MapOutputName('validTo')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $DatumTill,

        #[MapOutputName('firstName')]
        public string|Optional $Fornamn,

        #[MapOutputName('middleName')]
        public string|Optional $Mellannamn,

        #[MapOutputName('lastName')]
        public string|Optional $Efternamn,

        #[MapOutputName('givenName')]
        public string|Optional $Tilltalsnamn,
    ) {}
}
