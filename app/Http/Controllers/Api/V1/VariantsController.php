<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\VariantsFilter;
use App\Http\Resources\V1\VariantsResource;
use App\Models\Variants;
use App\Http\Requests\Api\V1\Variants\StoreVariantsRequest;
use App\Http\Requests\Api\V1\Variants\UpdateVariantsRequest;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

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
        return new VariantsResource(Variants::create($request->all()));
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
    public function update(UpdateVariantsRequest $request, Variants $variant)
    {
        $variant->update($request->validated());

        return new VariantsResource($variant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($variants_id)
    {
        if (!Auth::user()->is_admin) {
            return $this->error('Only administrators are authorized to perform this action.', 403);
        }

        try {
            $variant = Variants::findOrFail($variants_id);
            $variant->delete();

            return $this->ok('Variant was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Variant not found.', 404);
        }
    }
}