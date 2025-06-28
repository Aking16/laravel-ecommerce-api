<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Variants;
use App\Http\Requests\StoreVariantsRequest;
use App\Http\Requests\UpdateVariantsRequest;

class VariantsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Variants $variants)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variants $variants)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVariantsRequest $request, Variants $variants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variants $variants)
    {
        //
    }
}
