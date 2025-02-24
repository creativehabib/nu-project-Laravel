<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Phone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match("/^01\d*$/", $value)) {
            $fail('The :attribute must be start with 01');
        }
        if(strlen($value) !== 11) {
            $fail('The :attribute must be 11 digits');
        }
    }
}
