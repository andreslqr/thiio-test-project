<?php

use App\Http\Controllers\V1\User\UsersController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UsersController::class);