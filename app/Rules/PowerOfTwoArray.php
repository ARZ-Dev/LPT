<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PowerOfTwoArray implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $count = count($value);
        if ( !(($count & ($count - 1)) == 0 && $count != 0) ) {
            $fail('The :attribute must be a power of 2 (2, 4, 8, 16, 32, 64, ...).');
        }
    }
}
