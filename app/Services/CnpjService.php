<?php

namespace App\Services;

class CnpjService
{
    public static function sanitize(string $cnpj): string
    {
        return preg_replace('/\D/', '', $cnpj);
    }
}