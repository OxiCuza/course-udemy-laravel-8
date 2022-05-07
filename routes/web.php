<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\HomeController;
use \Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');
Route::get('contact', [HomeController::class, 'contact'])
    ->name('home.contact');
Route::get('secret', [HomeController::class, 'secret'])
    ->name('home.secret')
    ->middleware('can:secret-link');
Route::resource('posts', PostController::class);
