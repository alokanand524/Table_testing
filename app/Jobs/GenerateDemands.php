<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateDemands
{
    public function handle()
    {
        // \Log::info('GenerateDemands job is running.');

        // Calculate the previous and new payment periods based on the current date
        $requiredField = $this->calculatePaymentPeriods();

        // Get new payment period values
        $newPaymentFrom = $requiredField['newPaymentFrom'];
        $newPaymentTo = $requiredField['newPaymentTo'];

        // Get consumer IDs already present in the new period
        $existingConsumers = DB::table('swm_demands')
            ->where('payment_from', $newPaymentFrom)
            ->where('payment_to', $newPaymentTo)
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
            // You might want to log this or handle it differently
            return;
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
                'stampdate' => Carbon::now('Asia/Kolkata')->format('Y-m-d, H:i:s'),
                'demand_date' => $newPaymentFrom,
                'is_deactivate' => 0,
            ];
        })->toArray();

        // Insert data into the table
        DB::table('swm_demands')->insert($insertData);
    }

    protected function calculatePaymentPeriods()
    {
        $currentDate = Carbon::now();
        $previousPaymentFrom = $currentDate->copy()->subMonth()->startOfMonth();
        $previousPaymentTo = $previousPaymentFrom->copy()->endOfMonth();
        $newPaymentFrom = $previousPaymentFrom->copy()->addMonth()->startOfMonth();
        $newPaymentTo = $newPaymentFrom->copy()->endOfMonth();

        return [
            "previousPaymentFrom" => $previousPaymentFrom->toDateString(),
            "previousPaymentTo" => $previousPaymentTo->toDateString(),
            "newPaymentFrom" => $newPaymentFrom->toDateString(),
            "newPaymentTo" => $newPaymentTo->toDateString(),
        ];
    }
}
