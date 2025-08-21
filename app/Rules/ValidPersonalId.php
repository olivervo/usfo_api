<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Personnummer\Personnummer;

class ValidPersonalId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if( ! Personnummer::valid($value)) {
            $fail('The :attribute must be a valid Swedish personal identity number.');
        }
    }
}
