<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Payment\StorePaymentRequest;
use App\Http\Requests\Api\V1\Payment\UpdatePaymentRequest;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Payment;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentsController extends Controller
{
    use ApiResponses;

    public function index()
    {
        return PaymentResource::collection(Payment::all());
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create(
            $request->validated() + [
                'status' => 'pending'
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
        return new PaymentResource($payment);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return new PaymentResource($payment);
    }

    public function destroy($payment_id)
    {
        try {
            $payment = Payment::findOrFail($payment_id);
            $payment->delete();

            return $this->ok('Payment was deleted successfully');
        } catch (ModelNotFoundException $th) {
            return $this->error('Payment not found.', 404);
        }
    }
}
