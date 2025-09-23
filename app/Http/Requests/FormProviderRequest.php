<?php

namespace App\Http\Requests;

use App\Services\CnpjService;
use Illuminate\Foundation\Http\FormRequest;

class FormProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'cnpj' => ['required', 'string', 'digits:14', 'unique:providers,cnpj'],
            'email' => ['nullable', 'email', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {   
        // Parse the 'nome' query parameter to 'name' if present
        $name = match (true) {
            $this->has('name') => $this->input('name'),
            $this->has('nome') => $this->input('nome'),
            default => null,
        };

        // Sanitize the cnpj input only digits
        $cnpj = $this->input('cnpj')? CnpjService::sanitize($this->input('cnpj')) : null;

        // Merge name and cnpj into the request data
        $this->merge([
            'name' => $name,
            'cnpj' => $cnpj,
        ]);
    }
}
