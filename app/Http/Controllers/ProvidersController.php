<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormProviderRequest;
use App\Http\Requests\IndexProviderRequest;
use App\Http\Resources\ProviderResource;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProvidersController extends Controller
{
    public function index(IndexProviderRequest $request)
    {
        $search = $request->input('search', '');

        $providers = Provider::where('name', 'like', "%$search%")
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return ProviderResource::collection($providers);
    }

    // public function show(Provider $provider)
    // {
    //     return new ProviderResource($provider);
    // }

    public function store(FormProviderRequest $request)
    {
        $provider = Provider::create($request->validated());

        return response()->json(['message' => 'ok', 'provider' => $provider], Response::HTTP_CREATED);
    }
    
    // public function update(FormProviderRequest $request, Provider $provider)
    // {
    //     $provider->update($request->validated());

    //     return response()->json(['message' => 'ok', 'provider' => $provider], Response::HTTP_OK);
    // }
}
