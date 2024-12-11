<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SwmDemandController extends Controller
{

   /*  public function calculatePaymentPeriods()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Calculate previous and new payment periods
        $previousPaymentFrom = $currentDate->copy()->subMonth()->startOfMonth();
        $previousPaymentTo = $previousPaymentFrom->copy()->endOfMonth();
        
        $newPaymentFrom = $previousPaymentFrom->copy()->addMonth()->startOfMonth();
        $newPaymentTo = $newPaymentFrom->copy()->endOfMonth();

        return [
               "previousPaymentFrom" => $previousPaymentFrom->toDateString(),
               "previousPaymentTo"  =>  $previousPaymentTo->toDateString(),
               "newPaymentFrom" => $newPaymentFrom->toDateString(),
               "newPaymentTo" => $newPaymentTo->toDateString()
            ];
    }


    public function createDemands(Request $request)
    {      

        // // Validate the request to accept a specific month/year if provided
        // $request->validate([
        //         'year' => 'required|integer',
        //         'month' => 'required|integer|between:1,12',
        //     ]);
            
        //     // Get the year and month from the request
        //     $year = $request->input('year');
        //     $month = $request->input('month');
            
        //     // Calculate the previous and new payment periods
        //     $previousPaymentFrom = Carbon::createFromDate($year, $month, 1)->subMonth()->startOfMonth();
        //     $previousPaymentTo = $previousPaymentFrom->copy()->endOfMonth();
            
        //     $newPaymentFrom = $previousPaymentFrom->copy()->addMonth()->startOfMonth();
        //     $newPaymentTo = $newPaymentFrom->copy()->endOfMonth();
  

        // Calculate the previous and new payment periods based on the current date
         $requiredField = $this->calculatePaymentPeriods();
         
         $requiredField['previousPaymentFrom'];
         $requiredField['previousPaymentTo'];
         
         $newPaymentFrom = $requiredField['newPaymentFrom'];
         $newPaymentTo = $requiredField['newPaymentTo'];
 
 

        // Get consumer IDs already present in the new period
        $existingConsumers = DB::table('swm_demands')
            ->where('payment_from', $requiredField['newPaymentFrom'])
            ->where('payment_to', $requiredField['newPaymentTo'])
            ->groupBy('consumer_id')
            ->pluck('consumer_id');

        // Fetch consumers from the previous period not already in the new period
        $dataToInsert = DB::table('swm_demands')
            ->where('payment_from', $requiredField['previousPaymentFrom'])
            ->where('payment_to', $requiredField['previousPaymentTo'])
            ->where('is_deactivate', 0)
            ->when($existingConsumers->isNotEmpty(), function ($query) use ($existingConsumers) {
                $query->whereNotIn('consumer_id', $existingConsumers);
            })
            ->get(['consumer_id', 'total_tax']);
        
        if ($dataToInsert->isEmpty()) {
            return response()->json([
                'message' => 'No data found to create demands.',
                'data' => []
            ], 200);
        }

        // Prepare data for insertion
        $insertData = $dataToInsert->map(function ($item) use ($newPaymentFrom, $newPaymentTo) {
            return [
                'consumer_id' => $item->consumer_id,
                'total_tax' => $item->total_tax,
                'payment_from' => $newPaymentFrom,
                'payment_to' => $newPaymentTo,
                'paid_status' => 0,
                'last_payment_id' => 0,
                'user_id' => 2,
                'stampdate' => now()->setTimezone('Asia/Kolkata')->format('Y-m-d, H:i:s'),
                'demand_date' => $newPaymentFrom,
                'is_deactivate' => 0,
            ];
        })->toArray();

        // Insert data into the table
        DB::table('swm_demands')->insert($insertData);

        return response()->json([
            'status' => true,
            'message' => 'Demands created successfully!',
            'data' => $insertData,
        ], 201);
    } */

    
}


