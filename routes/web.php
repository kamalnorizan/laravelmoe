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

Route::get('/user', [UserController::class, 'index'])->name('user.index');
