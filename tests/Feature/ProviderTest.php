<?php

namespace Tests\Feature;

use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_provider()
    {
        $data = [
            'name' => 'Fornecedor Teste',
            'cnpj' => '11222333000181',
            'email' => 'teste@fornecedor.com'
        ];

        $response = $this->postJson('/api/providers', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'ok'
            ]);

        $this->assertDatabaseHas('providers', [
            'name' => 'Fornecedor Teste',
            'cnpj' => '11222333000181',
            'email' => 'teste@fornecedor.com'
        ]);
    }

    public function test_it_validates_input_when_creating_provider()
    {
        $data = [
            'name' => 'Te', // too short
            'cnpj' => '123', // invalid cnpj
            'email' => 'invalid-email'
        ];

        $response = $this->postJson('/api/providers', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'cnpj', 'email']);
    }

    public function test_it_can_list_providers_with_search_filter()
    {
        Provider::factory()->create(['name' => 'Fornecedor ABC']);
        Provider::factory()->create(['name' => 'Fornecedor XYZ']);
        Provider::factory()->create(['name' => 'Empresa DEF']);

        $response = $this->getJson('/api/providers?search=Fornecedor');

        $response->assertStatus(200);
        $responseData = $response->json();
        $providers = $responseData['data'] ?? $responseData;
        
        $this->assertCount(2, $providers);
        $this->assertTrue(
            collect($providers)->every(fn($provider) => 
                str_contains(strtolower($provider['nome']), 'fornecedor')
            )
        );
    }

    public function test_it_can_list_all_providers_without_filter()
    {
        Provider::factory()->count(3)->create();

        $response = $this->getJson('/api/providers');

        $response->assertStatus(200);
        $responseData = $response->json();
        $providers = $responseData['data'] ?? $responseData;
        
        $this->assertCount(3, $providers);
    }

    public function test_it_can_show_individual_provider()
    {
        $provider = Provider::factory()->create([
            'name' => 'Provider Individual',
            'cnpj' => '11222333000181',
            'email' => 'individual@provider.com'
        ]);

        $response = $this->getJson("/api/providers/{$provider->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $provider->id,
                    'nome' => 'Provider Individual',
                    'cnpj' => '11222333000181',
                    'email' => 'individual@provider.com'
                ]
            ]);
    }

    public function test_it_can_create_provider_with_sanitized_cnpj()
    {
        $data = [
            'name' => 'Fornecedor Teste',
            'cnpj' => '11.222.333/0001-81', // formatted cnpj
            'email' => 'teste@fornecedor.com'
        ];

        $response = $this->postJson('/api/providers', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('providers', [
            'cnpj' => '11222333000181'
        ]);
    }

    public function test_it_cannot_create_provider_with_duplicate_cnpj()
    {
        // First, create a provider
        Provider::factory()->create(['cnpj' => '11222333000181']);

        $data = [
            'name' => 'Outro Fornecedor',
            'cnpj' => '11222333000181',
            'email' => 'outro@fornecedor.com'
        ];

        $response = $this->postJson('/api/providers', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cnpj']);
    }

    public function test_it_should_fail_when_creating_provider_with_invalid_cnpj_algorithm()
    {
        $data = [
            'name' => 'Fornecedor com CNPJ Inválido',
            'cnpj' => '12345678000199', // CNPJ with invalid check digits
            'email' => 'teste@invalido.com'
        ];

        $response = $this->postJson('/api/providers', $data);

        // This test waits to fail due to invalid CNPJ check digits
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cnpj'])
            ->assertJsonFragment([
                'cnpj' => ['O campo cnpj deve ser um CNPJ válido.']
            ]);
    }

    public function test_it_should_fail_when_creating_provider_with_all_same_digits_cnpj()
    {
        $data = [
            'name' => 'Fornecedor CNPJ Inválido',
            'cnpj' => '11111111111111', // CNPJ with all same digits
            'email' => 'teste@invalido.com'
        ];

        $response = $this->postJson('/api/providers', $data);

        // This test waits to fail due to invalid CNPJ (all same digits)
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['cnpj'])
            ->assertJsonFragment([
                'cnpj' => ['O campo cnpj deve ser um CNPJ válido.']
            ]);
    }
}
