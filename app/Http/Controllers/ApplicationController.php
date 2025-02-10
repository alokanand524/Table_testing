<?php

namespace App\Http\Controllers;

use App\Models\ApplicationGenerate;
use Exception;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:application_generates,email',
        ]);
    try{

            $count = ApplicationGenerate::count(); 
            
            $newId = $count + 1; 
        
            
            $applicationNumber = 'ALOK-' . str_pad($newId, 3, '0', STR_PAD_LEFT);

            $application = ApplicationGenerate::create([
                'application_number' => $applicationNumber,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json([
                'message' => 'Application created successfully!',
                'data' => $application,
            ], 201);
        }

        catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create application!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
