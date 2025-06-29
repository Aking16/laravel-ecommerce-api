<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\VariantCategoriesFilter;
use App\Http\Resources\V1\VariantCategoriesResource;
use App\Models\VariantCategories;
use App\Http\Requests\Api\V1\VariantCategories\StoreVariantCategoriesRequest;
use App\Http\Requests\Api\V1\VariantCategories\UpdateVariantCategoriesRequest;

class VariantCategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(VariantCategoriesFilter $filters)
    {
        return VariantCategoriesResource::collection(VariantCategories::filter($filters)->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantCategoriesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VariantCategories $variantCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VariantCategories $variantCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantCategoriesRequest $request, VariantCategories $variantCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VariantCategories $variantCategories)
    {
        //
    }
}
