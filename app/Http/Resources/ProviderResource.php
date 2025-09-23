<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'cnpj' => $this->cnpj,
            'email' => $this->email,
            'criado_em' => $this->created_at,
            'atualizado_em' => $this->updated_at,
            'deletado_em' => $this->deleted_at,
        ];
    }
}
