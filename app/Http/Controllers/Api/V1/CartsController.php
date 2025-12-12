<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\CartsFilter;
use App\Models\Carts;
use App\Http\Requests\Api\V1\Carts\StoreCartsRequest;
use App\Http\Requests\Api\V1\Carts\UpdateCartsRequest;
use App\Http\Resources\V1\CartsResource;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CartsController extends ApiController
{
    use ApiResponses;

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
        $cart = Carts::create([
            'user_id' => Auth::id(),
        ]);

        $cart->attributes()->attach($request->validated('attributes_id'), [
            'discounts_id' => $request->validated('discounts_id')
        ]);

        return new CartsResource($cart);
    }

    /**
     * Display the specified resource.
     */
    public function show(Carts $cart, CartsFilter $filters)
    {
        Gate::authorize('view', $cart);

        return new CartsResource($cart::filter($filters)->findOrFail($cart->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartsRequest $request, Carts $cart)
    {
        Gate::authorize('update', $cart);

        try {
            $cart->attributes()->attach($request->validated('attributes_id'), [
                'discounts_id' => $request->validated('discounts_id')
            ]);
        } catch (QueryException  $e) {
            return $this->error('Attribute already exists on this cart.', 409);
        }

        return new CartsResource($cart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cart_id)
    {
        try {
            $cart = Carts::findOrFail($cart_id);

            Gate::authorize('delete', $cart);

            $cart->delete();

            return $this->ok('Cart was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Cart not found.', 404);
        }
    }
}
