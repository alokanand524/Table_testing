<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\SwmDemandController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/users', [UserController::class, 'insertData']);

Route::post('/users/getData', [UserController::class, 'getAllData']);

Route::post('/users/search', [UserController::class, 'getSpecificUserData']);

// Route::delete('/users/{id}', [UserController::class, 'deleteData']);

Route::post('/users/delete', [UserController::class, 'deleteDataByEmail']);

Route::post('/users/update', [UserController::class, 'updateData']);




//update data 


// Route::post('/swm-demands', [SwmDemandController::class, 'store']);
// Route::post('/getData/swm-demands', [SwmDemandController::class, 'index']);

Route::post('/swm-demands/generate', [SwmDemandController::class, 'createDemands']);

