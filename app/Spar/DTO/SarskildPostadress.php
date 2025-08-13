<?php

namespace App\Spar\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class SarskildPostadress extends Data
{
    public function __construct(
        public SvenskAdress|Optional $SvenskAdress,
        public InternationellAdress|Optional $InternationellAdress,
    ) {}
}
