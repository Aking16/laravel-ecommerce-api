<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Gallery\StoreGalleryRequest;
use App\Http\Requests\Api\V1\Gallery\UpdateGalleryRequest;
use App\Http\Resources\V1\GalleryResource;
use App\Models\Gallery;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GalleryResource::collection(Gallery::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        return new GalleryResource(Gallery::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return new GalleryResource($gallery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->validated());

        return new GalleryResource($gallery);
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
            $gallery = Gallery::findOrFail($id);
            $gallery->delete();

            return $this->ok('Gallery was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Category not found.', 404);
        }
    }
}
