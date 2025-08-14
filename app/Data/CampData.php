<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\CamelCaseMapper;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

#[MapOutputName(CamelCaseMapper::class)]
class CampData extends Data
{
    public function __construct(
        public int $id,
        public string $camp_name,
        public int $year,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $start_date,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $end_date,
        public int $number_males,
        public int $number_females,
        public ?int $price,
        public ?Carbon $publish_at,
        public ?string $registration_code,
        public string $name,
        public int $total_spaces,
        public int $free_males,
        public int $free_females,
        public int $availability,
        public bool $is_available,
        public bool $is_published,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    ) {}
}
