<?php

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
    return view('welcome');
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

});