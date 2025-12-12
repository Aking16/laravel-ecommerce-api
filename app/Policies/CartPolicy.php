<?php

namespace App\Policies;

use App\Models\Carts;
use App\Models\User;

class CartPolicy
{
    public function view(User $user, Carts $cart): bool
    {
        return $user->id === $cart->user_id || $user->is_admin;
    }

    public function update(User $user, Carts $cart): bool
    {
        return $user->id === $cart->user_id || $user->is_admin;
    }

    public function delete(User $user, Carts $cart): bool
    {
        return $user->id === $cart->user_id || $user->is_admin;
    }
}
