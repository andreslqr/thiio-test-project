<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::post('login', LoginController::class)->withoutMiddleware('auth:api')->name('login');