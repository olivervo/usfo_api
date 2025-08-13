<?php

namespace App\Spar\DTO\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class GetLatestCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Data|Uncastable
    {
        $type = $property->type->dataClass;

        if (is_array($value)) {
            return $type::from($value[0]);
        }

        if (is_object($value)) {
            return $type::from($value);
        }

        return Uncastable::create();
    }
}
