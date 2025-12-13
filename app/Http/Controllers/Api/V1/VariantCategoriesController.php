<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\VariantCategoriesFilter;
use App\Http\Resources\V1\VariantCategoriesResource;
use App\Models\VariantCategories;
use App\Http\Requests\Api\V1\VariantCategories\StoreVariantCategoriesRequest;
use App\Http\Requests\Api\V1\VariantCategories\UpdateVariantCategoriesRequest;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class VariantCategoriesController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(VariantCategoriesFilter $filters)
    {
        return VariantCategoriesResource::collection(VariantCategories::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantCategoriesRequest $request)
    {
        return new VariantCategoriesResource(VariantCategories::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(VariantCategories $variantCategory)
    {
        return new VariantCategoriesResource($variantCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantCategoriesRequest $request, VariantCategories $variantCategory)
    {
        $variantCategory->update($request->validated());

        return new VariantCategoriesResource($variantCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($variantCategories_id)
    {
        if (!Auth::user()->is_admin) {
            return $this->error('Only administrators are authorized to perform this action.', 403);
        }

        try {
            $product = VariantCategories::findOrFail($variantCategories_id);
            $product->delete();

            return $this->ok('Product was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Product not found.', 404);
        }
    }
}
