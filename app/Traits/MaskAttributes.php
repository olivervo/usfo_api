<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait MaskAttributes
{
    public function toMasked(): array
    {
        $data = $this->toArray();

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = Str::mask($value, '*', 3);
            }
        }

        return $data;
    }
}
