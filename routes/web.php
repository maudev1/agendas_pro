<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UsersController;

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

Route::get('/', function () {
   return redirect('/admin/home');
});

Auth::routes();

//DASHBOARD
Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');


Route::controller(UsersController::class)->group(function () {
    Route::get('/admin/users', 'index');
    Route::post('/admin/users', 'create');

});


Route::controller(CustomerController::class)->group(function () {
    Route::get('/admin/customers', 'index');
    Route::get('/admin/customers/to_datatables', 'to_datatables');
    Route::post('/admin/customers', 'store');

});

Route::controller(ScheduleController::class)->group(function(){
    Route::get('/admin/schedule', 'index');
});