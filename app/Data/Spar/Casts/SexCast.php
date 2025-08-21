<?php

namespace App\Data\Spar\Casts;

use App\Enums\Sex;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class SexCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Sex|Uncastable
    {
        if (is_string($value)) {
            if ($value === 'MAN') {
                return Sex::male;
            }

            if ($value === 'KVINNA') {
                return Sex::female;
            }
        }

        return Uncastable::create();
    }
}
