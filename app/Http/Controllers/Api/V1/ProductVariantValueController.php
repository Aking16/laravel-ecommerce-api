<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ProductVariantValue;
use App\Http\Requests\Api\V1\VariantsValues\StoreProductVariantValueRequest;
use App\Http\Requests\Api\V1\VariantsValues\UpdateProductVariantValueRequest;

class ProductVariantValueController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreProductVariantValueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariantValue $productVariantValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariantValue $productVariantValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantValueRequest $request, ProductVariantValue $productVariantValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariantValue $productVariantValue)
    {
        //
    }
}
