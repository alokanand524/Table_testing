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

Route::Controllers(UserController::class)->group(function () {

    Route::post('/users/create', 'insertData')->name('insertData');
    Route::post('/users/getData',  'getAllData')->name('getAllData');
    Route::post('/users/search', 'getSpecificUserData')->name('getSpecificUserData');
    Route::post('/users/delete', 'deleteDataByEmail')->name('deleteDataByEmail');
    Route::post('/users/update', 'updateData')->name('updateData');

});


//generate demand
Route::post('/swm-demands/generate', [SwmDemandController::class, 'createDemands']);

