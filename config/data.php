<?php

use App\Data\Spar\Casts\GetLatestCast;
use App\Data\Spar\Folkbokforingsadress;
use App\Data\Spar\Namn;
use App\Data\Spar\Persondetaljer;
use App\Data\Spar\SarskildPostadress;
use App\Data\Spar\Utlandsadress;

return [
    'date_format' => [DATE_ATOM, 'Y-m-d'],

    'features' => [
        'cast_and_transform_iterables' => true,
    ],

    'casts' => [
        DateTimeInterface::class => Spatie\LaravelData\Casts\DateTimeInterfaceCast::class,
        BackedEnum::class => Spatie\LaravelData\Casts\EnumCast::class,
        Namn::class => GetLatestCast::class,
        Persondetaljer::class => GetLatestCast::class,
        SarskildPostadress::class => GetLatestCast::class,
        Folkbokforingsadress::class => GetLatestCast::class,
        Utlandsadress::class => GetLatestCast::class,
    ],
];
