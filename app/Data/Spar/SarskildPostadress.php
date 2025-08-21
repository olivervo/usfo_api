<?php

namespace App\Data\Spar;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SarskildPostadress extends Data
{
    public function __construct(
        #[MapOutputName('swedishAddress')]
        public SvenskAdress|Optional $SvenskAdress,

        #[MapOutputName('internationalAddress')]
        public InternationellAdress|Optional $InternationellAdress,
    ) {}
}
