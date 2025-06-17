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
use Illuminate\Support\Facades\Storage;

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
        $filePath = $request->file('file')->store('uploads/galleries', 'public');

        $gallery = Gallery::create([
            'name' => $request->name,
            'file' => $filePath,
        ]);

        return new GalleryResource($gallery);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        // return Storage::disk('public')->response($gallery->file);
        return new GalleryResource($gallery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($gallery->file && Storage::disk('public')->exists($gallery->file)) {
                Storage::disk('public')->delete($gallery->file);
            }

            $filePath = $request->file('file')->store('uploads/galleries', 'public');

            $data['file'] = $filePath;
        }

        $gallery->update($data);

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
