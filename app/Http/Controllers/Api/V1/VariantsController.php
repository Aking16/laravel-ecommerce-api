<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\VariantsFilter;
use App\Http\Resources\V1\VariantsResource;
use App\Models\Variants;
use App\Http\Requests\Api\V1\Variants\StoreVariantsRequest;
use App\Http\Requests\Api\V1\Variants\UpdateVariantsRequest;
use App\Traits\ApiResponses;

class VariantsController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(VariantsFilter $filters)
    {
        return VariantsResource::collection(Variants::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Variants $variant, VariantsFilter $filters)
    {
        return new VariantsResource($variant::filter($filters)->findOrFail($variant->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantsRequest $request, Variants $variants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variants $variants)
    {
        //
    }
}