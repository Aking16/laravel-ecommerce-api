<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use App\Models\CartItem;
use App\Http\Filters\V1\CartItemsFilter;
use App\Http\Requests\Api\V1\CartItems\StoreCartItemsRequest;
use App\Http\Requests\Api\V1\CartItems\UpdateCartItemsRequest;
use App\Http\Resources\V1\CartItemsResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class CartItemsController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(CartItemsFilter $filters)
    {
        return CartItemsResource::collection(
            CartItem::filter($filters)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemsRequest $request)
    {
        $item = CartItem::create($request->validated());

        return new CartItemsResource(
            $item->load('attribute.variant.product')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        Gate::authorize('view', $cartItem);

        return new CartItemsResource(
            $cartItem->load('attribute.variant.product')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemsRequest $request, CartItem $cartItem)
    {
        Gate::authorize('update', $cartItem);

        $cartItem->update($request->validated());

        return new CartItemsResource(
            $cartItem->load('attribute.variant.product')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = CartItem::findOrFail($id);

            Gate::authorize('delete', $item);

            $item->delete();

            return $this->ok('Cart item deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->error('Cart item not found.', 404);
        }
    }
}
