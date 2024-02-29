<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RefreshLoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class)->withoutMiddleware('auth:api')->name('register');

Route::post('login', LoginController::class)->withoutMiddleware('auth:api')->name('login');

Route::post('refresh', RefreshLoginController::class)->name('refresh');

Route::post('logout', LogoutController::class)->name('logout');
