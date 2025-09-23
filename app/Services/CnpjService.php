<?php

namespace App\Services;

class CnpjService
{
    public static function sanitize(string $cnpj): string
    {
        return preg_replace('/\D/', '', $cnpj);
    }

    /**
     * Check if the CNPJ is valid
     * Rules verified:
     * - Must be 14 digits
     * - Cannot have all digits the same
     * - Check digit validation
     *
     * @param string $cnpj
     * @return boolean
     */
    public static function isValid(string $cnpj): bool
    {
        $cnpj = self::sanitize($cnpj);

        if (strlen($cnpj) !== 14) {
            return false;
        }

        // Check if all digits are the same
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Check digit validation
        for ($i = 0, $j = 5, $sumResult = 0; $i < 12; $i++) {
            $sumResult += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sumResult % 11;
        if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        for ($i = 0, $j = 6, $sumResult = 0; $i < 13; $i++) {
            $sumResult += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sumResult % 11;
        return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
    }

    public static function format(string $cnpj): string
    {
        $cnpj = self::sanitize($cnpj);
        return substr($cnpj, 0, 2) . '.' . 
               substr($cnpj, 2, 3) . '.' . 
               substr($cnpj, 5, 3) . '/' . 
               substr($cnpj, 8, 4) . '-' . 
               substr($cnpj, 12, 2);
    }
}