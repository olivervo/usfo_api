<?php

namespace App\Spar\DTO;

use App\Spar\DTO\Casts\BooleanCast;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PersonsokningSvarspost extends Data
{
    public function __construct(
        #[MapOutputName('personId')]
        public PersonId $PersonId,

        #[MapOutputName('confidential')]
        #[WithCast(BooleanCast::class)]
        public bool $Sekretessmarkering,

        #[MapOutputName('protectedIdentity')]
        #[WithCast(BooleanCast::class)]
        public bool $SkyddadFolkbokforing,

        #[MapOutputName('updatedAt')]
        public Carbon|Optional $SenasteAndringSPAR,

        #[MapOutputName('name')]
        public Namn|Optional $Namn,

        #[MapOutputName('personDetails')]
        public Persondetaljer|Optional $Persondetaljer,

        #[MapOutputName('address')]
        /** @var Folkbokforingsadress|null */
        public Folkbokforingsadress|Optional $Folkbokforingsadress,

        #[MapOutputName('specialAddress')]
        /** @var SarskildPostadress|null */
        public SarskildPostadress|Optional $SarskildPostadress,

        /** @var Utlandsadress|null */
        #[MapOutputName('internationalAddress')]
        public Utlandsadress|Optional $Utlandsadress,
    ) {}
}
