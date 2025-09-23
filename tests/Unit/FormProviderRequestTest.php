<?php

namespace Tests\Unit;

use App\Http\Requests\FormProviderRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FormProviderRequestTest extends TestCase
{
    public function test_it_authorizes_requests()
    {
        $request = new FormProviderRequest();
        
        $this->assertTrue($request->authorize());
    }

    public function test_it_validates_required_fields()
    {
        $request = new FormProviderRequest();
        $rules = $request->rules();

        $validator = Validator::make([], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
        $this->assertArrayHasKey('cnpj', $validator->errors()->toArray());
    }

    public function test_it_has_correct_validation_rules()
    {
        $request = new FormProviderRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('cnpj', $rules);
        $this->assertArrayHasKey('email', $rules);
        
        $this->assertContains('required', $rules['name']);
        $this->assertContains('min:3', $rules['name']);
        $this->assertContains('required', $rules['cnpj']);
        $this->assertContains('digits:14', $rules['cnpj']);
        $this->assertContains('nullable', $rules['email']);
    }
}
