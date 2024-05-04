<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerAuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::post('customer/register', [CustomerAuthController::class, 'register']);



Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('customer/login',    [CustomerAuthController::class, 'login'])->name('apin.login');
    Route::post('customer/logout',   [CustomerAuthController::class, 'logout'])->name('apin.logout');
    Route::post('customer/register', [CustomerAuthController::class, 'register'])->name('apin.register');

    Route::get('teste', function(){


        return response()->json(['ai amizade']);


    });



});
