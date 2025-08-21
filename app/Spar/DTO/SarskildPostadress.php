<?php

namespace App\Spar\DTO;

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
