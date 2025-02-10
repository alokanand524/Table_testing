<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserFileDetails extends Controller
{
    public function userDetails(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string|unique:user_details',
            'files.*' => 'required|file|mimes:jpg,png,pdf,docx|max:2',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        
        $user = UserDetails::create($request->only('name', 'mobile'));
    
      
        if ($request->hasFile('files')) { 

            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {

                    $filePath = $file->store('uploads', 'public');
                    $user->files()->create(['file_path' => $filePath]);

                } else {
                    \Log::error('File upload error: ', ['error' => $file->getError()]);
                }
            }
        }
    
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);

    }



    public function showDetails($id)
    {
        $user = UserDetails::with('files')->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user' => $user], 200);
    }
}
