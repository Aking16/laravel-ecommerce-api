<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ProductSku;
use App\Http\Requests\Api\V1\Sku\StoreProductSkuRequest;
use App\Http\Requests\Api\V1\Sku\UpdateProductSkuRequest;

class ProductSkuController extends ApiController
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
    public function store(StoreProductSkuRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSku $productSku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSku $productSku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductSkuRequest $request, ProductSku $productSku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSku $productSku)
    {
        //
    }
}
