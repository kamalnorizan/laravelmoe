<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FirstController;

// DB::listen(function ($event) {
//     dump($event->sql);
// });
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [FirstController::class, 'about']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('auth');
Route::post('/user/ajaxloadusers', [UserController::class, 'ajaxLoadUsers'])->name('user.ajaxLoadUsers');
Route::post('/user/ajaxloaduser', [UserController::class, 'ajaxLoadUser'])->name('user.ajaxLoadUser');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.delete');
