<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Payment\StorePaymentRequest;
use App\Http\Requests\Api\V1\Payment\UpdatePaymentRequest;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Carts;
use App\Models\Payment;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PaymentsController extends Controller
{
    use ApiResponses;

    public function index()
    {
        return PaymentResource::collection(Payment::all());
    }

    public function store(StorePaymentRequest $request)
    {

        $cart = Carts::findOrFail($request->cart_id);

        Gate::authorize('create', [Payment::class, $cart]);

        $payment = Payment::create(
            $request->validated() + [
                'status' => 'pending',
                'user_id' => Auth::id(),
            ]
        );

        // TODO: integrate Zarinpal here
        // Example:
        // $payment->update([
        //     'status' => 'paid',
        //     'transaction_id' => $gatewayResponse->id
        // ]);

        return new PaymentResource($payment);
    }

    public function show(Payment $payment)
    {
        Gate::authorize('view', $payment);

        return new PaymentResource($payment);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        Gate::authorize('update', $payment);

        $payment->update($request->validated());

        return new PaymentResource($payment);
    }

    public function destroy($payment_id)
    {
        try {
            $payment = Payment::findOrFail($payment_id);

            Gate::authorize('delete', $payment);

            $payment->delete();

            return $this->ok('Payment was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Payment not found.', 404);
        }
    }
}
