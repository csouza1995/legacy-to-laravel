<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'cnpj' => $this->generateValidCnpj(),
            'email' => $this->faker->companyEmail(),
        ];
    }

    /**
     * Generate a valid unique CNPJ
     */
    private function generateValidCnpj(): string
    {
        // Generate a unique 8-digit base
        $base = str_pad((string) $this->faker->unique()->numberBetween(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        $branch = '0001'; // Branch number
        
        // Calculate first check digit
        $sequence = $base . $branch;
        $sum = 0;
        $multiplier = 5;
        
        for ($i = 0; $i < 12; $i++) {
            $sum += $sequence[$i] * $multiplier;
            $multiplier = ($multiplier == 2) ? 9 : $multiplier - 1;
        }
        
        $remainder = $sum % 11;
        $firstDigit = ($remainder < 2) ? 0 : 11 - $remainder;
        
        // Calculate second check digit
        $sequence .= $firstDigit;
        $sum = 0;
        $multiplier = 6;
        
        for ($i = 0; $i < 13; $i++) {
            $sum += $sequence[$i] * $multiplier;
            $multiplier = ($multiplier == 2) ? 9 : $multiplier - 1;
        }
        
        $remainder = $sum % 11;
        $secondDigit = ($remainder < 2) ? 0 : 11 - $remainder;
        
        return $sequence . $secondDigit;
    }
}
