<?php

namespace Tests\Unit;

use App\Models\Provider;
use App\Services\ProviderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProviderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProviderService $providerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->providerService = new ProviderService();
    }

    public function test_it_can_create_provider_with_transaction()
    {
        $data = [
            'name' => 'Test Provider',
            'cnpj' => '11222333000181',
            'email' => 'test@provider.com'
        ];

        $provider = $this->providerService->create($data);

        $this->assertInstanceOf(Provider::class, $provider);
        $this->assertDatabaseHas('providers', $data);
    }

    public function test_it_can_update_provider_with_transaction()
    {
        $provider = Provider::factory()->create([
            'name' => 'Original Name',
            'cnpj' => '11222333000181'
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@provider.com'
        ];

        $updatedProvider = $this->providerService->update($provider, $updateData);

        $this->assertEquals('Updated Name', $updatedProvider->name);
        $this->assertEquals('updated@provider.com', $updatedProvider->email);
        $this->assertDatabaseHas('providers', [
            'id' => $provider->id,
            'name' => 'Updated Name'
        ]);
    }

    public function test_it_can_delete_provider_with_soft_delete()
    {
        $provider = Provider::factory()->create();

        $result = $this->providerService->delete($provider);

        $this->assertTrue($result);
        $this->assertSoftDeleted('providers', ['id' => $provider->id]);
    }
}
