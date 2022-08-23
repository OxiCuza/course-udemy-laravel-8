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
Route::get('posts/tag/{tag}', [\App\Http\Controllers\TagController::class, 'index'])->name('posts.tag.index');

Route::resource('posts.comments', \App\Http\Controllers\PostCommentController::class)->only('store');
Route::resource('users.comments', \App\Http\Controllers\UserCommentController::class)->only('store');
Route::resource('users', \App\Http\Controllers\UserController::class)->only(['show', 'edit', 'update']);
