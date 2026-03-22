<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\ProductAttributeFilter;
use App\Http\Requests\Api\V1\Attributes\StoreAttributesRequest;
use App\Http\Requests\Api\V1\Attributes\UpdateAttributesRequest;
use App\Http\Resources\V1\AttributesResource;
use App\Models\ProductAttribute;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ProductAttributeController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductAttributeFilter $filters)
    {
        return AttributesResource::collection(ProductAttribute::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributesRequest $request)
    {
        return new AttributesResource(ProductAttribute::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAttribute $productAttribute, ProductAttributeFilter $filters)
    {
        return new AttributesResource($productAttribute::filter($filters)->findOrFail($productAttribute->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributesRequest $request, ProductAttribute $productAttribute)
    {
        $productAttribute->update($request->validated());

        return new AttributesResource($productAttribute);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($attributes_id)
    {
        if (!Auth::user()->is_admin) {
            return $this->error('Only administrators are authorized to perform this action.', 403);
        }

        try {
            $attributes = ProductAttribute::findOrFail($attributes_id);
            $attributes->delete();

            return $this->ok('Product attributes was deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Product attributes not found.', 404);
        }
    }
}
