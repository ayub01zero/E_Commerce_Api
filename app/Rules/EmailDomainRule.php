<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailDomainRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedDomains = ['gmail.com', 'yahoo.com', 'hotmail.com'];
        $emailDomain = explode('@', $value)[1];
        if (!in_array($emailDomain, $allowedDomains)) {
            $fail("The $attribute domain is not allowed.");
        }
    }
}
