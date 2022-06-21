<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/fotos', function (){
    return view('photos', ['title' => 'Galeria de fotos']);
});

Auth::routes();

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/admin/users', [App\Http\Controllers\UsersController::class, 'index'])->name('admin/users');
Route::get('/admin/posts', [App\Http\Controllers\PostsController::class, 'index'])->name('admin/posts');

