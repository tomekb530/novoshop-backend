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
        $payRequest = $request->user()->checkoutCharge($request->amount, $request->description);
        $payment->makePayment($request->user(), $request->amount, $payRequest->id, $request->description);

        return response()->json([
            'id' => $payment->id,
            'data' => $payRequest
        ]);
    }

    public function refund(Request $request)
    {
        $payment = Payment::find($request->id);
        if (!$payment) {
            return response()->json([
                'error' => 'Payment not found'
            ], 404);
        }
        
        if ($payment->status == 'refunded') {
            return response()->json([
                'error' => 'Payment already refunded'
            ], 400);
        }

        if ($payment->status != 'paid') {
            return response()->json([
                'error' => 'Payment not paid'
            ], 400);
        }

        $session = Cashier::stripe()->checkout->sessions->retrieve($payment->stripe_payment_id);
        $paymentIntent = $session->payment_intent;

        $payment->status = 'refunded';
        $payment->save();
        return $request->user()->refund($paymentIntent);
    }

    public function history(Request $request)
    {
        Log::info('History');
        $payments = Payment::where('user_id', $request->user()->id)->get();
        return response()->json($payments);
    }

    public function info(Request $request)
    {
        $payment = Payment::find($request->id);
        if (!$payment) {
            return response()->json([
                'error' => 'Payment not found'
            ], 404);
        }

        if ($payment->status != 'paid' || $payment->status != 'refunded') {
            $stripe_id = $payment->stripe_payment_id;
            $status = Cashier::stripe()->checkout->sessions->retrieve($stripe_id)->payment_status;
            $payment->status = $status;
            $payment->save();  
        }
        return response()->json(Cashier::stripe()->checkout->sessions->retrieve($stripe_id));
    }

    public function show(Request $request)
    {
        $payments = Payment::all();
        return response()->json($payments);
    }
}
