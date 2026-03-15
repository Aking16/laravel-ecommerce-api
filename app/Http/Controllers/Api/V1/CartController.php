<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\CartsFilter;
use App\Models\Cart;
use App\Http\Requests\Api\V1\Carts\StoreCartRequest;
use App\Http\Requests\Api\V1\Carts\UpdateCartRequest;
use App\Http\Resources\V1\CartResource;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CartController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(CartsFilter $filters)
    {
        return CartResource::collection(Cart::filter($filters)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $cart = Cart::create([
            'user_id' => Auth::id(),
        ]);

        $cart->items()->create([
            'attribute_id' => $request->validated('attribute_id'),
            'quantity' => $request->validated('quantity') ?? 1,
        ]);

        return new CartResource($cart);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart, CartsFilter $filters)
    {
        Gate::authorize('view', $cart);

        return new CartResource($cart::filter($filters)->findOrFail($cart->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        Gate::authorize('update', $cart);

        try {
            $cart->attributes()->attach($request->validated('attributes_id'), [
                'discounts_id' => $request->validated('discounts_id')
            ]);
        } catch (QueryException  $e) {
            return $this->error('Attribute already exists on this cart.', 409);
        }

        return new CartResource($cart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cart_id)
    {
        try {
            $cart = Cart::findOrFail($cart_id);

            Gate::authorize('delete', $cart);

            $cart->delete();

            return $this->ok('Cart was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Cart not found.', 404);
        }
    }
}
