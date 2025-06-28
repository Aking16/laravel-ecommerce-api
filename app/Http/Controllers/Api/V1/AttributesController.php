<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\AttributesFilter;
use App\Http\Requests\Api\V1\Attributes\StoreAttributesRequest;
use App\Http\Requests\Api\V1\Attributes\UpdateAttributesRequest;
use App\Http\Resources\V1\AttributesResource;
use App\Models\Attributes;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AttributesController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(AttributesFilter $filters)
    {
        return AttributesResource::collection(Attributes::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributesRequest $request)
    {
        return new AttributesResource(Attributes::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Attributes $attributes)
    {
        return new AttributesResource($attributes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributesRequest $request, Attributes $attributes)
    {
        $attributes->update($request->validated());

        return new AttributesResource($attributes);
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
            $attributes = Attributes::findOrFail($attributes_id);
            $attributes->delete();

            return $this->ok('Attributes was deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Attributes not found.', 404);
        }
    }
}
