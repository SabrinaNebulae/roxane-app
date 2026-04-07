<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCaptcha implements ValidationRule
{
    public function __construct(private readonly string $sessionKey = 'captcha_answer') {}

    /**
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (trim((string) $value) !== (string) session($this->sessionKey)) {
            $fail('Le code de vérification est incorrect.');
        }
    }
}
