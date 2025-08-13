<?php

namespace App\Spar\DTO\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class BooleanCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): bool|Uncastable
    {
        if (in_array($value, ['JA', 'NEJ'], true)) {
            return $value === 'JA';
        }

        if (is_object($value)) {
            return $value->_ === 'JA';
        }

        return Uncastable::create();
    }
}
