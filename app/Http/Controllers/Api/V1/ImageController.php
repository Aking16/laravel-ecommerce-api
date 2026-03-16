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
            if ($image->file && Storage::disk('public')->exists($image->file)) {
                Storage::disk('public')->delete($image->file);
            }

            $filePath = $request->file('file')->store('uploads/galleries', 'public');

            $data['path'] = $filePath;
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
