<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RefreshLoginController;
use Illuminate\Support\Facades\Route;


Route::post('login', LoginController::class)->withoutMiddleware('auth:api')->name('login');

Route::post('refresh', RefreshLoginController::class)->name('refresh');