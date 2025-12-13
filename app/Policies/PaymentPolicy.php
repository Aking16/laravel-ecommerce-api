<?php

namespace App\Policies;

use App\Models\Carts;
use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function create(User $user, Carts $cart): bool
    {
        return $user->id === $cart->user_id || $user->is_admin;
    }

    public function view(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id || $user->is_admin;
    }

    public function update(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id || $user->is_admin;
    }

    public function delete(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id || $user->is_admin;
    }
}
