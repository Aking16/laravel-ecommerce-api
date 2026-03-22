<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponses;
use App\Models\ProductVariant;
use App\Http\Resources\V1\ProductVariantResource;
use App\Http\Filters\V1\ProductVariantFilter;
use App\Http\Requests\Api\V1\Variants\StoreVariantsRequest;
use App\Http\Requests\Api\V1\Variants\UpdateVariantsRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ProductVariantController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductVariantFilter $filters)
    {
        return ProductVariantResource::collection(ProductVariant::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantsRequest $request)
    {
        return new ProductVariantResource(ProductVariant::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $productVariant, ProductVariantFilter $filters)
    {
        return new ProductVariantResource($productVariant::filter($filters)->findOrFail($productVariant->id));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantsRequest $request, ProductVariant $productVariant)
    {
        $productVariant->update($request->validated());

        return new ProductVariantResource($productVariant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::user()->is_admin) {
            return $this->error('Only administrators are authorized to perform this action.', 403);
        }

        try {
            $product = ProductVariant::findOrFail($id);
            $product->delete();

            return $this->ok('Product variant was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Product variant not found.', 404);
        }
    }
}
