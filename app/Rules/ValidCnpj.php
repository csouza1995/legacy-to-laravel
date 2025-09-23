<?php

namespace App\Rules;

use App\Services\CnpjService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!CnpjService::isValid($value)) {
            $fail('O campo :attribute deve ser um CNPJ válido.');
        }
    }
}
