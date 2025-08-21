<?php

namespace App\Data\Spar;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class Utlandsadress extends Data
{
    public function __construct(
        #[MapOutputName('internationalAddress')]
        public InternationellAdress $InternationellAdress,
    ) {}
}
