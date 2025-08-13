<?php

namespace App\Spar\DTO;

use App\Enums\Sex;
use App\Spar\DTO\Casts\SexCast;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class Persondetaljer extends Data
{
    public function __construct(
        public Carbon $DatumFrom,
        public Carbon $DatumTill,
        #[WithCast(SexCast::class)]
        public Sex $Kon,
        public Carbon $Fodelsedatum,
    ) {}
}
