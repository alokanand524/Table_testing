<?php


use App\Http\Controllers\UserDetails;
use App\Http\Controllers\UserFileDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ConsumerTranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SwmDemandController;


use App\Http\Controllers\PersonController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(UserController::class)->group(function () {
    Route::post('/users/create', 'insertData')->name('insertData');
    Route::post('/users/getData', 'getAllData')->name('getAllData');
    Route::post('/users/search', 'getSpecificUserData')->name('getSpecificUserData');
    Route::post('/users/delete', 'deleteDataByEmail')->name('deleteDataByEmail');
    Route::post('/users/update', 'updateData')->name('updateData');
});



//generate demand
// Route::post('/swm-demands/generate', [SwmDemandController::class, 'createDemands']);


// Route::post('/applications', [ApplicationController::class, 'store']);





// Route::post('/users', [ConsumerTranController::class, 'createUser']);

// Route::get('/users', [ConsumerTranController::class, 'getUsers']);

// Route::post('/orders', [ConsumerTranController::class, 'createOrder']);

// Route::post('/initiate-payment', [ConsumerTranController::class, 'initiatePayment']);

// Route::post('/payment-success', [ConsumerTranController::class, 'handlePaymentSuccess']);



// Route::post('/people', [PersonController::class, 'store']);
// Route::get('/people/search', [PersonController::class, 'search']);
// Route::post('/transactions/pay', [PersonController::class, 'payNow']);
