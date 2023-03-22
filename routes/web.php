<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PublicScheduleController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\StoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

//DASHBOARD

Route::middleware(['auth', 'auth.basic'])->group(function(){

    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

    Route::controller(ScheduleController::class)->group(function(){
        Route::get('/admin/schedule', 'index');
        Route::get('/admin/schedules/{id}', 'getAll');
        Route::post('/admin/schedule', 'store');
        Route::post('/admin/schedule/{id}', 'update');
        Route::get('/admin/schedule/delete/{id}', 'delete');
        Route::get('/admin/urlgenerate/', 'urlGenerate');
        
    });


    Route::controller(UsersController::class)->group(function () {
        Route::get('/admin/users', 'index');
        Route::post('/admin/users', 'create');
    
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/admin/customers', 'index');
        Route::get('/admin/customers/to_datatables', 'to_datatables');
        Route::get('/admin/customers/edit/{id}', 'edit');
        Route::get('/admin/customers/all', 'show');
        Route::post('/admin/customers', 'store');
        Route::post('/admin/customers/update/{id}', 'update');
        Route::get('/admin/customers/delete/{id}', 'destroy');
    
    });

    Route::controller(ConfigController::class)->group(function () {
        Route::get('/admin/config/', 'index');
    
    
    });
    
    Route::controller(StoreController::class)->group(function () {
        Route::get('/admin/store/', 'index');
        Route::post('/admin/store/', 'store');
        Route::post('/admin/store/{id}', 'update');
    
    });
    
});


Route::controller(PublicScheduleController::class)->group(function () {
    Route::get('/schedule/{id}/', 'index');
    
});

