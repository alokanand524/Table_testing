<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\companies;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Method to insert user and company data
    public function insertData(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'company_name' => 'required',
            'mobile' => "required",
            'pan' => 'required',
            'aadhar' => 'required',
        ]);

        try {

            // Check if the user already exists by email
            $user = User::where('email', $validated['email'])->first();

            // Variable to track if a new user was created
            $newUserCreated = false;

            if ($user) {

                // Check if the user name matches the provided name
                if ($user->name !== $validated['name']) {
                    throw new Exception('ERROR: Adding New Company for existing user');
                }

                // Check if the company already exists for this user
                $existingCompany = companies::where('user_id', $user->id)
                    ->where('company_name', $validated['company_name'])
                    ->first();

                if ($existingCompany) {
                    // throw new \Exception('User and company already exist');
                    throw new Exception('User already exist');
                }

                DB::beginTransaction();

                // Add a new company for the existing user
                companies::create([
                    'user_id' => $user->id,
                    'company_name' => $validated['company_name'],
                ]);
            } 
            
            else {

                // If user does not exist, create a new user and company
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'mobile' => $validated['mobile'],
                    'pan' => $validated['pan'],
                    'aadhar' => $validated['aadhar'],
                ]);

                $newUserCreated = true;

                companies::create([
                    'user_id' => $user->id,
                    'company_name' => $validated['company_name'],
                ]);
            }

            // Commit all operations
            DB::commit();

            // Prepare a success message
            $message = $newUserCreated
                ? 'User and company successfully created'
                : 'New company added for the existing user';

            return response()->json(['status' => true,'message' => $message], 200);
        } 
        
        catch (Exception $e) {

            DB::rollback();

            \Log::error('Error inserting data: ' . $e->getMessage());

            return response()->json(['status' => false,'message' => $e->getMessage()], 500);
        }
    }

    // Method to get all data using INNER JOIN
    public function getAllData(Request $request)
    {
        try {
            $data = DB::table('users')->get();

            return response()->json(['status' => true,'message' => 'Data retrieved successfully','data' => $data]);
        } 
        
        catch (Exception $e) {

            return response()->json(['status' => false,'message' => 'Unable to retrieve data'], 500);
        }
    }

    // Method to get user specific data by POST method
    public function getSpecificUserData(UserRequest $request)
    {
        try {
            $mUsers = new User();
            $data = null;
            
            // if ($request->filled('email')) {
            //     $data = $mUsers->searchByEmail($request->email);
            //         if (!$data) {
            //             throw new Exception('User not found for the provided email.');
            //         }
            // } elseif ($request->filled('mobile')) {
            //     $data = $mUsers->searchByMobile($request->mobile);
            //         if (!$data) {
            //             throw new Exception('User not found for the provided mobile number.');
            //         }
            // } elseif ($request->filled('pan')) {
            //     $data = $mUsers->searchByPan($request->pan);
            //         if (!$data) {
            //             throw new Exception('User not found for the provided PAN.');
            //         }
            // } elseif ($request->filled('aadhar')) {
            //     $data = $mUsers->searchByAadhar($request->aadhar);
            //         if (!$data) {
            //             throw new Exception('User not found for the provided Aadhar.');
            //         }
            // } 

            

            switch (true) {

                case $request->filled('email'):
                    $data = $mUsers->searchByUserDetails('email',$request->email);
                        if (!$data) {
                            throw new Exception('User not found for the provided email.');
                        }
                    break;

                case $request->filled('mobile'):
                    $data = $mUsers->searchByUserDetails('mobile', $request->mobile);
                        if (!$data) {
                            throw new Exception('User not found for the provided mobile number.');
                        }
                    break;

                case $request->filled('pan'):
                    $data = $mUsers->searchByUserDetails('pan', $request->pan);
                        if (!$data) {
                            throw new Exception('User not found for the provided PAN.');
                        }
                    break;

                case $request->filled('aadhar'):
                    $data = $mUsers->searchByUserDetails('aadhar',$request->aadhar);
                        if (!$data) {
                            throw new Exception('User not found for the provided Aadhar.');
                        }
                    break;
                    
                default:
                    throw new Exception('No Such Data Found.');

            }    

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $data,
            ]);
        } 
        
        catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    // Method to update user and company data
    public function updateData(UserRequest $request)
    {
        // // Validate the incoming data manually
        // $validator = Validator::make($request->all(), [
        //     // 'user_id' => 'required|integer|exists:users,id',
        //     // 'company_id' => 'required|integer|exists:companies,id',
        //     // 'company_name' => 'required|string',
        //     'name' => 'required|string',
        //     'email' => 'required|email:rfc,dns',
        //     'mobile' => 'nullable|integer|digits:10',
        //     'pan' => 'nullable|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
        //     'aadhar' => 'nullable|integer|digits:12',
        // ]);

        try {
            // Handle validation failure
            if ($request->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'details' => $request->errors()
                ], 422);
            }

            // Fetch the user by ID
            $user = User::find($request->email);
            if (!$user) {
                throw new Exception('User not found');
            }

            // Fetch the company by ID
            // $company = companies::where('id', $request->company_id)
            //     ->where('user_id', $request->email)
            //     ->first();

            // if (!$company) {
            //     throw new Exception('Company not found for the specified user');
            // }

            // Check if all provided data are the same as the existing data
            if (
                $user->name === $request->name &&
                $user->email === $request->email &&
                // $company->company_name === $request->company_name
                $user->mobile === $request->mobile &&
                $user->pan === $request->pan &&
                $user->aadhar === $request->aadhar 
            ) {
                throw new Exception('Cannot update, data already exist');
            }

            DB::beginTransaction();

            // Store previous data in history table
            // \DB::table('companies_log')->insert([
            //     'user_id' => $user->id,
            //     'company_id' => $company->id,
            //     'company_name' => $company->company_name,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);

            // Update user details
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'pan'=> $request->pan,
                'aadhar'=> $request->aadhar,

            ]);

            // Update company details
            // $company->update([
            //     'company_name' => $request->company_name,
            // ]);

            DB::commit();

            return response()->json(['status' => true,'message' => 'Updated successfully']);
        } 

        catch (Exception $e) {

            DB::rollback();
            \Log::error('Error updating data: ' . $e->getMessage());

            return response()->json(['status' => false,'message' => $e->getMessage(),], 500);
        }
    }

    // Method to delete user data by email
    public function deleteDataByEmail(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email', // Ensure the email exists in the users table
        ]);

        try {
            // Find the user by email
            $user = User::where('email', $validated['email'])->firstOrFail();

            // Find all companies associated with this user
            // $companies = companies::where('user_id', $user->id)->get();

            // DB::beginTransaction();
            // // Delete the companies
            // foreach ($companies as $company) {
            //     $company->delete();
            // }

            // Delete the user
            $user->delete();

            // Commit the transaction after all operations
            // DB::commit();

            return response()->json(['status' => true, 'message' => 'UserS deleted successfully']);

        } 
        
        catch (Exception $e) {

            DB::rollback();
            \Log::error('Error deleting data: ' . $e->getMessage());

            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}