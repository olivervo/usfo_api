<?php

namespace App\Spar\DTO;

use App\Spar\DTO\Casts\BooleanCast;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PersonsokningSvarspost extends Data
{
    public function __construct(
        public PersonId $PersonId,

        #[WithCast(BooleanCast::class)]
        public bool $Sekretessmarkering,

        #[WithCast(BooleanCast::class)]
        public bool $SkyddadFolkbokforing,

        public Carbon|Optional $SenasteAndringSPAR,

        public Namn|Optional $Namn,

        public Persondetaljer|Optional $Persondetaljer,

        /** @var Folkbokforingsadress|null */
        public Folkbokforingsadress|Optional $Folkbokforingsadress,

        /** @var SarskildPostadress|null */
        public SarskildPostadress|Optional $SarskildPostadress,

        /** @var Utlandsadress|null */
        public Utlandsadress|Optional $Utlandsadress,
    ) {}
}
