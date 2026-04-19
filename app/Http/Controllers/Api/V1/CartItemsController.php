<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponses;
use App\Models\CartItem;
use App\Models\Cart;
use App\Http\Filters\V1\CartItemsFilter;
use App\Http\Requests\Api\V1\CartItems\StoreCartItemsRequest;
use App\Http\Requests\Api\V1\CartItems\UpdateCartItemsRequest;
use App\Http\Resources\V1\CartItemsResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CartItemsController extends ApiController
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(CartItemsFilter $filters)
    {
        $cartItems = CartItem::filter($filters)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return CartItemsResource::collection($cartItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemsRequest $request)
    {
        // Get or create user's active cart
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        // Check if item already exists in cart
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('sku_id', $request->validated('sku_id'))
            ->first();


        if ($existingItem) {
            // Update quantity instead of creating duplicate
            $existingItem->update([
                'quantity' => $existingItem->quantity + ($request->validated('quantity') ?? 1)
            ]);

            $item = $existingItem;
        } else {
            // Create new cart item
            $item = CartItem::create([
                'cart_id' => $cart->id,
                'sku_id' => $request->validated('sku_id'),
                'quantity' => $request->validated('quantity') ?? 1,
            ]);
        }

        return new CartItemsResource(
            $item->load('sku.product')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        Gate::authorize('view', $cartItem);

        if ($cartItem->cart->user_id !== Auth::id()) {
            return $this->error('Unauthorized', 403);
        }

        return new CartItemsResource(
            $cartItem->load('sku.product')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemsRequest $request, CartItem $cartItem)
    {
        Gate::authorize('update', $cartItem);

        $cartItem->update($request->validated());

        return new CartItemsResource($cartItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = CartItem::findOrFail($id);

            if ($item->cart->user_id !== Auth::id()) {
                return $this->error('Unauthorized', 403);
            }

            Gate::authorize('delete', $item);

            $item->delete();

            return $this->ok('Cart item deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->error('Cart item not found.', 404);
        }
    }
}
