<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\CartsFilter;
use App\Models\Cart;
use App\Http\Requests\Api\V1\Carts\StoreCartRequest;
use App\Http\Requests\Api\V1\Carts\UpdateCartRequest;
use App\Http\Resources\V1\CartResource;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $carts = Cart::filter($filters)
            ->where('user_id', Auth::id())
            ->get();

        return CartResource::collection($carts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        // Check if user already has an active cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->whereDoesntHave('order')
            ->first();

        if ($existingCart) {
            return $this->error('User already has an active cart', 409);
        }

        $cart = Cart::create([
            'user_id' => Auth::id(),
        ]);

        return new CartResource($cart->load('items.sku'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart, CartsFilter $filters)
    {
        Gate::authorize('view', $cart);

        if ($cart->user_id !== Auth::id()) {
            return $this->error('Unauthorized', 403);
        }

        return new CartResource($cart->load('items.sku.product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        Gate::authorize('update', $cart);

        if ($cart->user_id !== Auth::id()) {
            return $this->error('Unauthorized', 403);
        }

        if ($request->has('items')) {
            foreach ($request->input('items') as $itemData) {
                // Support different operation types
                $operation = $itemData['operation'] ?? 'update'; // update, add, remove, set

                if (isset($itemData['id'])) {
                    // Update by cart item ID
                    $item = $cart->items()->find($itemData['id']);
                    if ($item) {
                        $this->processCartItem($item, $itemData, $operation);
                    }
                } elseif (isset($itemData['sku_id'])) {
                    // Find or create by SKU ID
                    $item = $cart->items()->where('sku_id', $itemData['sku_id'])->first();

                    if ($item) {
                        $this->processCartItem($item, $itemData, $operation);
                    } elseif ($operation !== 'remove' && ($itemData['quantity'] ?? 1) > 0) {
                        // Create new item only if quantity > 0 and not a remove operation
                        $cart->items()->create([
                            'sku_id' => $itemData['sku_id'],
                            'quantity' => $itemData['quantity'] ?? 1,
                        ]);
                    }
                }
            }
        }

        return new CartResource($cart);
    }

    protected function processCartItem($item, $itemData, $operation)
    {
        $quantity = $itemData['quantity'] ?? 1;

        switch ($operation) {
            case 'add':
                // Add to existing quantity
                $newQuantity = $item->quantity + $quantity;
                if ($newQuantity <= 0) {
                    $item->delete();
                } else {
                    $item->update(['quantity' => $newQuantity]);
                }
                break;

            case 'remove':
                // Remove item regardless of quantity
                $item->delete();
                break;

            case 'set':
                // Set exact quantity
                if ($quantity <= 0) {
                    $item->delete();
                } else {
                    $item->update(['quantity' => $quantity]);
                }
                break;

            case 'update':
            default:
                // Default update behavior
                if ($quantity <= 0) {
                    $item->delete();
                } else {
                    $item->update(['quantity' => $quantity]);
                }
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cart_id)
    {
        try {
            $cart = Cart::findOrFail($cart_id);

            Gate::authorize('delete', $cart);

            if ($cart->user_id !== Auth::id()) {
                return $this->error('Unauthorized', 403);
            }

            $cart->delete();

            return $this->ok('Cart was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Cart not found.', 404);
        }
    }

    /**
     * Get the current user's active cart
     */
    public function getCurrentCart()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->whereDoesntHave('order')
            ->with('items.sku.product')
            ->first();

        if (!$cart) {
            return $this->error('No active cart found', 404);
        }

        return new CartResource($cart);
    }

    /**
     * Clear all items from the cart
     */
    public function clearCart(Cart $cart)
    {
        Gate::authorize('update', $cart);

        if ($cart->user_id !== Auth::id()) {
            return $this->error('Unauthorized', 403);
        }

        $cart->items()->delete();

        return $this->ok('Cart cleared successfully');
    }

    /**
     * Calculate cart total
     */
    public function calculateTotal(Cart $cart)
    {
        Gate::authorize('view', $cart);

        if ($cart->user_id !== Auth::id()) {
            return $this->error('Unauthorized', 403);
        }

        $total = $cart->items->sum(function ($item) {
            return $item->sku->price * $item->quantity;
        });

        return $this->success([
            'total' => $total,
            'currency' => 'IRT',
            'items_quantity' => $cart->items->sum('quantity')
        ]);
    }
}
