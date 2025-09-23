<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormProviderRequest;
use App\Http\Requests\IndexProviderRequest;
use App\Http\Resources\ProviderResource;
use App\Models\Provider;
use App\Services\ProviderService;
use Illuminate\Http\Response;

class ProvidersController extends Controller
{
    public function __construct(
        private ProviderService $providerService
    ) {}

    public function index(IndexProviderRequest $request)
    {
        $search = $request->input('search', '');

        $providers = Provider::where('name', 'like', "%$search%")
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return ProviderResource::collection($providers);
    }

    public function show(Provider $provider)
    {
        return new ProviderResource($provider);
    }

    public function store(FormProviderRequest $request)
    {
        $provider = $this->providerService->create($request->validated());

        return response()->json([
            'message' => 'ok', 
            'provider' => new ProviderResource($provider)
        ], Response::HTTP_CREATED);
    }
}
