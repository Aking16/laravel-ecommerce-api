<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponses;
use App\Models\Image;
use App\Http\Requests\Api\V1\Image\StoreImageRequest;
use App\Http\Requests\Api\V1\Image\UpdateImageRequest;
use App\Http\Resources\V1\ImageResource;
use Illuminate\Support\Facades\Storage;

class ImageController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ImageResource::collection(Image::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $data = $request->validated();

        $filePath = $request->file('file')->store('uploads/galleries', 'public');

        if (!empty($data['is_main'])) {
            Image::where('imageable_id', $data['imageable_id'])
                ->where('imageable_type', $data['imageable_type'])
                ->update(['is_main' => false]);
        }

        // Category should only have one image
        // Remove the previous image if exists
        if ($data['imageable_type'] === 'App\Models\Category') {
            $oldImage = Image::where('imageable_id', $data['imageable_id'])
                ->where('imageable_type', $data['imageable_type'])
                ->first();

            if ($oldImage) {
                if ($oldImage->path && Storage::disk('public')->exists($oldImage->path)) {
                    Storage::disk('public')->delete($oldImage->path);
                }

                $oldImage->delete();
            }
        }

        $image = Image::create([
            'path' => $filePath,
            'is_main' => $data['is_main'] ?? false,
            'imageable_id' => $data['imageable_id'],
            'imageable_type' => $data['imageable_type'],
        ]);

        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($image->path && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $filePath = $request->file('file')->store('uploads/galleries', 'public');

            $data['path'] = $filePath;
        }

        if (!empty($data['is_main'])) {
            Image::where('imageable_id', $image->imageable_id)
                ->where('imageable_type', $image->imageable_type)
                ->update(['is_main' => false]);
        }

        $image->update($data);

        return new ImageResource($image);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();

        return $this->ok('Image deleted successfully');
    }
}
