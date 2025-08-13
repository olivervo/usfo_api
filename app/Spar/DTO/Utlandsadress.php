<?php

namespace App\Spar\DTO;

use Spatie\LaravelData\Data;

class Utlandsadress extends Data
{
    public function __construct(
        public InternationellAdress $InternationellAdress,
    ) {}
}
