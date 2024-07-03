<?php

use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PublicScheduleController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Models\Customer;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth', 'auth.basic'])->group(function () {

    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

    Route::controller(ScheduleController::class)->group(function () {
        Route::get('/admin/schedules', 'index');
        Route::get('/admin/schedules/{id}', 'getAll');
        Route::post('/admin/schedule', 'store');
        Route::post('/admin/schedule/{id}', 'update');
        Route::get('/admin/schedule/delete/{id}', 'delete');
        Route::get('/admin/urlgenerate/', 'urlGenerate');
    });

    Route::controller(ConfigController::class)->group(function () {
        Route::get('/admin/config/', 'index');
    });

    Route::controller(StoreController::class)->group(function () {
        Route::get('/admin/store/', 'index');
        Route::post('/admin/store/', 'store');
        Route::post('/admin/store/{id}', 'update');
        Route::get('/admin/store/workdays', 'workDays');

    });


    Route::prefix("admin")->group(function () {

        // Profile Route
        Route::resource("profiles", ProfileController::class)
        ->middleware('checkPermission:profiles')->except("show");

        Route::get('profiles/to_datatables', [ProfileController::class, 'to_datatables'])->name("profiles.datatables");

        // Users Route
        Route::resource("users", UsersController::class)
        ->middleware('checkPermission:users')->except("show");

        Route::get('users/to_datatables', [UsersController::class, 'to_datatables'])->name("users.datatables");

        // Customer Route
        Route::resource("customers", CustomerController::class)
        ->middleware('checkPermission:customers')->except("show");

        Route::get('customers/to_datatables', [CustomerController::class, 'to_datatables'])->name("customers.datatables");

        // Products Route 
        Route::resource("products", ProductController::class)
        ->middleware('checkPermission:products')->except("show");

        Route::get('products/to_datatables', [ProductController::class, 'to_datatables'])->name("products.datatables");
    });
});


Route::controller(PublicScheduleController::class)->group(function () {
    Route::get('/schedule/{id}/', 'index');
    Route::post('/schedule/date/', 'getDate');
    Route::post('/schedule/products', 'getProducts');
    Route::post('/schedule', 'store');
    Route::post('/schedule/{id}', 'update');
    Route::get('/schedule/status/{id}', 'getStatus');

});

