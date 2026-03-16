<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    public function view(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id || $user->is_admin;
    }

    public function update(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id || $user->is_admin;
    }

    public function delete(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id || $user->is_admin;
    }
}
