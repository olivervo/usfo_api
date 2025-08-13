<?php

use App\Spar\DTO\Casts\GetLatestCast;
use App\Spar\DTO\Folkbokforingsadress;
use App\Spar\DTO\Namn;
use App\Spar\DTO\Persondetaljer;
use App\Spar\DTO\SarskildPostadress;
use App\Spar\DTO\Utlandsadress;

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
