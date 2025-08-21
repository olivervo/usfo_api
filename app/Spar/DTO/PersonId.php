<?php

namespace App\Spar\DTO;

use Spatie\LaravelData\Attributes\MapOutputName;
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
        #[MapOutputName('idNumber')]
        public string $IdNummer,
        #[MapOutputName('personIdType')]
        public PersonIdType $Typ,
    ) {}
}
