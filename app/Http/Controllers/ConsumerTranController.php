<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\ConTrans;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class ConsumerTranController extends Controller {
    
    public function createUser(Request $request) {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:consumers,email',
            'mobile' => 'required|string|unique:consumers,mobile',
        ]);
    
        $consumer = Consumer::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile
        ]);
    
        return response()->json(['message' => 'Consumer created successfully', 'consumer' => $consumer], 201);
    }
    
    // #################################################################################
    
    public function getUsers() {
        $consumers = Consumer::all();
        return response()->json(['consumers' => $consumers], 200);
    }
    
    // #################################################################################
    
    public function createOrder(Request $request) {
        $request->validate([
            'consumer_id' => 'required|exists:consumers,id', 
            'amount' => 'required|numeric|min:1'
        ]);
        
        $order = ConTrans::create([
            'consumer_id' => $request->consumer_id,
            'order_no' => 'ODR-' . rand(1000, 9999),
            'amount' => $request->amount,
        ]);
        
        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }
    
    // #################################################################################
    public function initiatePayment(Request $request) {
        $request->validate([
            'order_id' => 'required|exists:con_trans,id'
        ]);
        
        $order = ConTrans::findOrFail($request->order_id);
        
        $api = new Api(env('RAZORPAY_ID'), env('RAZORPAY_KEY'));
        
        $razorpayOrder = $api->order->create([
            'receipt' => $order->order_no,
            'amount' => $order->amount * 100, 
            'currency' => 'INR',
            'payment_capture' => 1
        ]);
        
        $order->transaction_no = 'TRN-' . Str::padLeft($order->id, 7, '0');
        $order->save();
        
        return response()->json([
            'order_id' => $order->id,
            'razorpay_order_id' => $razorpayOrder['id'],
            'amount' => $order->amount,
            'currency' => 'INR',
            'key' => env('RAZORPAY_KEY')
        ]);
    }
    
    // #################################################################################
    public function handlePaymentSuccess(Request $request) {
        $request->validate([
            'order_id' => 'required|exists:con_trans,id', 
            'payment_status' => 'required|string'
        ]);

        $order = ConTrans::findOrFail($request->order_id);
        $order->status = $request->payment_status;
        $order->save();

        return response()->json(['message' => 'Payment status updated', 'order' => $order], 200);
    }
}
