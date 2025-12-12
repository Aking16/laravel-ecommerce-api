<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\CartsFilter;
use App\Models\Carts;
use App\Http\Requests\Api\V1\Carts\StoreCartsRequest;
use App\Http\Requests\Api\V1\Carts\UpdateCartsRequest;
use App\Http\Resources\V1\CartsResource;

class CartsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartsFilter $filters)
    {
        return CartsResource::collection(Carts::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartsRequest $request)
    {
        $cart = Carts::create([]);

        $cart->attributes()->attach($request->validated('attributes_id'), [
            'discounts_id' => $request->validated('discounts_id')

        ]);

        return $cart;
    }

    /**
     * Display the specified resource.
     */
    public function show(Carts $cart, CartsFilter $filters)
    {
        return new CartsResource($cart::filter($filters)->findOrFail($cart->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartsRequest $request, Carts $carts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carts $carts)
    {
        //
    }
}
