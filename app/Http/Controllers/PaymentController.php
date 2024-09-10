<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $payment = new Payment();
        $payRequest = $request->user()->checkoutCharge($request->amount, "test");
        $payment->makePayment($request->user(), $request->amount, $payRequest->id, "test");
        //json url and id
        return response()->json([
            'id' => $payment->id,
            'stripe_payment_id' => $payRequest->id,
            'amount' => $request->amount,
            'url' => $payRequest->url
        ]);
    }

    public function status(Request $request)
    {
        $payment = Payment::find($request->id);
        if (!$payment) {
            return response()->json([
                'error' => 'Payment not found'
            ], 404);
        }
        if ($payment->status == 'paid') {
            return response()->json([
                'status' => $payment->checkStatus()
            ]);
        }
        $stripe_id = $payment->stripe_payment_id;
        $status = Cashier::stripe()->checkout->sessions->retrieve($stripe_id)->payment_status;
        $payment->status = $status;
        $payment->save();

        return response()->json([
            'status' => $payment->checkStatus()
        ]);
    }

    public function refund(Request $request)
    {
        return $request->user()->refund($request->amount);
    }

    public function history(Request $request)
    {
        return $request->user()->history();
    }

    public function info(Request $request)
    {
        $payment = Payment::find($request->id);
        if (!$payment) {
            return response()->json([
                'error' => 'Payment not found'
            ], 404);
        }
        return response()->json($payment);
    }
}
