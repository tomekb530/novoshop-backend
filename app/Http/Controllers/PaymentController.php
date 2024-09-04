<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $payment = new Payment();
        $payRequest = $request->user()->pay($request->amount);
        $payment->makePayment($request->user(), $request->amount, $payRequest->id, "test");
        return $payRequest->client_secret;
    }

    public function checkStatus(Request $request)
    {
        return $request->user()->checkStatus($request->payment_id);
    }

    public function refund(Request $request)
    {
        return $request->user()->refund($request->amount);
    }

    public function status(Request $request)
    {
        return $request->user()->status($request->payment_id);
    }

    public function history(Request $request)
    {
        return $request->user()->history();
    }
}
