<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SubCategory;
use App\Http\Requests\Api\V1\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\Api\V1\SubCategory\UpdateSubCategoryRequest;
use App\Http\Filters\V1\SubCategoryFilter;
use App\Http\Resources\V1\SubCategoryResource;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryFilter $filters)
    {
        return SubCategoryResource::collection(SubCategory::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        return new SubCategoryResource(SubCategory::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        return new SubCategoryResource($subCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {
        $subCategory->update($request->validated());

        return new SubCategoryResource($subCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sub_category_id)
    {
        if (!Auth::user()->is_admin) {
            return $this->error('Only administrators are authorized to perform this action.', 403);
        }

        try {
            $subCategory = SubCategory::findOrFail($sub_category_id);
            $subCategory->delete();

            return $this->ok('Sub Category was deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Sub Category not found.', 404);
        }
    }
}
