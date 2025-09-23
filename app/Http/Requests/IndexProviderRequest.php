<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class IndexProviderRequest extends FormRequest
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
            'search' => ['nullable', 'string', 'min:1']
        ];
    }

    protected function prepareForValidation(): void
    {   
        // Parse the 'q' query parameter to 'search' if present
        $search = match (true) {
            $this->has('search') => $this->input('search'),
            $this->has('q') => $this->input('q'),
            default => null,
        };

        // Sanitize the search input using Str helper
        if ($search !== null) {
            $search = Str::of($search)->trim()->toString();
        }

        // Merge search into the request data
        $this->merge([
            'search' => $search
        ]);
    }
}
