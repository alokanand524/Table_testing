<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RozorpayController extends Controller
{
    public function index()
    {
        return view('razorpay');
    }

    public function payment(Request $request)
    {

        $amount = intval($request->input('amount'));
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));


        $orderData = [
            'receipt' => 'order_rcpt_' . rand(1000, 9999),
            'amount' => $amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ];

        $order = $api->order->create($orderData);

        try {
            $order = $api->order->create($orderData);
            return view('payment', ['orderId'=>$order['id'], 'amount'=>$amount * 100]);
        } catch (\Exception $e) {
            dd("Razorpay Error: " . $e->getMessage());
        }
        
    }

    public function callback(Request $request)
    {
        dd(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    //     $payid = $request->payid;
    //     $orderid = $request->orderid;
    //     $signature = $request->signature;

    //     $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    //     try{
    //         $attributes = [
    //             'razorpay_order_id' => $orderid,
    //             'razorpay_payment_id' => $payid,
    //             'razorpay_signature' => $signature
    //         ];

    //         $api->utility->verifyPaymentSignature($attributes);
    //         echo "Payment Verified : ".$payid;
    //     }catch(\Exception $e){
    //         echo "Payment Verification Failed !";
    //     }
    // }
}
}