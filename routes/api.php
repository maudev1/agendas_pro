<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api;


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


Route::middleware(['auth:sanctum'])->group(function(){
    Route::resource('schedule', Api\ScheduleController::class)->except('create');
    Route::resource('company', Api\CompanyController::class)->except('create');
    Route::resource('product', Api\ProductController::class)->except('create');

});

Route::prefix('auth')->group(function () {
    Route::post('login', [Api\LoginController::class, 'login']);
    Route::post('register', [Api\RegisterController::class, 'register']);
    // Route::post('logout', [AuthController::class, 'loginUser']);


});

