<?php

namespace App\Spar\DTO;

use Spatie\LaravelData\Data;

enum PersonIdType: string
{
    case PERSONNUMMER = 'PERSONNUMMER';
    case SAMORDNINGSNUMMER = 'SAMORDNINGSNUMMER';
    case IMMUNITETSNUMMER = 'IMMUNITETSNUMMER';
}

class PersonId extends Data
{
    public function __construct(
        public string $IdNummer,
        public PersonIdType $Typ,
    ) {}
}
