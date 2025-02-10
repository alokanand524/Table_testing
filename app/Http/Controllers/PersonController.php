<?php
namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\people_trans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class PersonController extends Controller
{
    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:people,email',
            'mobile' => 'required|string|unique:people,mobile',
            'amount' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Create person
            $person = Person::create($request->only(['name', 'email', 'mobile']));

            // Generate unique order number
            $order_no = 'ORD-' . strtoupper(uniqid());

            // Create transaction
            $transaction = people_trans::create([
                'person_id' => $person->id,
                'order_no' => $order_no,
                'payment_trans' => '', // Initially empty
                'amount' => $request->amount,
                'status' => 'unpaid',
            ]);

            DB::commit();
            return redirect()->route('people.show', $person->id)->with('success', 'Person created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while creating the person: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $person = Person::with('transactions')->findOrFail($id);
        return view('people.show', compact('person'));
    }

    public function payment(Request $request) 
    {
        $request->validate(['id' => 'required|exists:people_trans,id']);

        $transaction = people_trans::find($request->id);

        // Generate unique order number
        $order_no = 'ORD-' . strtoupper(uniqid());

        // Convert amount to paise (Razorpay requires amount in paise)
        $amount = intval($transaction->amount) * 100;

        // Initialize Razorpay API
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Create Razorpay order
        try {
            $orderData = [
                'receipt' => $order_no,
                'amount' => $amount,
                'currency' => 'INR',
                'payment_capture' => 1,
            ];

            $order = $api->order->create($orderData);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Razorpay order creation failed: ' . $e->getMessage()]);
        }

        // Store order details in DB
        DB::beginTransaction();
        try {
            $transaction->order_no = $order_no;
            $transaction->payment_trans = $order['id']; // Razorpay order ID
            $transaction->status = 'pending';
            $transaction->save();

            DB::commit();
            
            // Redirect to payment page with order details
            return view('people.payment', [ // Ensure this view exists
                'orderId' => $order['id'],
                'amount' => $amount,
                'transactionId' => $transaction->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Payment initialization failed: ' . $e->getMessage()]);
        }
    }
}
