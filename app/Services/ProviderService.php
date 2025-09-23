<?php

namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class ProviderService
{
    public function create(array $data): Provider
    {
        return DB::transaction(function () use ($data) {
            return Provider::create($data);
        });
    }

    public function update(Provider $provider, array $data): Provider
    {
        return DB::transaction(function () use ($provider, $data) {
            $provider->update($data);
            return $provider->fresh();
        });
    }

    public function delete(Provider $provider): bool
    {
        return DB::transaction(function () use ($provider) {
            return $provider->delete();
        });
    }
}
