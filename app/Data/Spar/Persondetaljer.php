<?php

namespace App\Data\Spar;

use App\Data\Spar\Casts\SexCast;
use App\Enums\Sex;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class Persondetaljer extends Data
{
    public function __construct(
        #[MapOutputName('validFrom')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $DatumFrom,

        #[MapOutputName('validTo')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $DatumTill,

        #[WithCast(SexCast::class)]
        #[MapOutputName('sex')]
        public Sex $Kon,

        #[MapOutputName('birthDate')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $Fodelsedatum,
    ) {}
}
