<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirstController;

DB::listen(function ($event) {
    dump($event->sql);
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [FirstController::class, 'about']);
