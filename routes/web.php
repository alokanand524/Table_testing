<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\RozorpayController;
use App\Http\Controllers\PersonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/users', [UserController::class, 'index'])->name('users.index');
// Route::post('/users', [UserController::class, 'store'])->name('users.store');
// Route::get('/order/{id}', [UserController::class, 'generateOrder'])->name('generateOrder');
// Route::get('/pay/{id}', [UserController::class, 'payOrder'])->name('payOrder');
// Route::get('/payment-success', [UserController::class, 'paymentSuccess'])->name('payment.success');


Route::get("/razorpay",[RozorpayController::class,'index']);
Route::post("/razorpay/payment",[RozorpayController::class,'payment'])->name('razorpay.payment');
Route::get("/razorpay/callback",[RozorpayController::class,'callback'])->name('razorpay.callback');




// Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
// Route::post('/people', [PersonController::class, 'store'])->name('people.store');
// Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');
// Route::post("/people/payment",[PersonController::class,'payment'])->name('people.payment');
