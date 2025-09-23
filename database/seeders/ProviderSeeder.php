<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    public array $data = [
        [
            'name' => 'Fornecedor ABC Ltda',
            'cnpj' => '11222333000181',
            'email' => 'contato@fornecedorabc.com.br'
        ],
        [
            'name' => 'Empresa XYZ S.A.',
            'cnpj' => '98765432000195',
            'email' => 'vendas@empresaxyz.com.br'
        ],
        [
            'name' => 'Comercial DEF ME',
            'cnpj' => '12345678000195',
            'email' => 'comercial@def.com.br'
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $provider) {
            Provider::create($provider);
        }
    }
}
