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


Auth::routes();
Route::group(['middleware' => 'auth'],function (){
    Route::get('/home', [App\Http\Controllers\PostsController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\PostsController::class, 'index']);
    Route::get('/logs', [App\Http\Controllers\PostsController::class, 'logs'])->name('logs');
    Route::get('parse', [App\Http\Controllers\PostsController::class, 'parse'])->name('parse');
});
