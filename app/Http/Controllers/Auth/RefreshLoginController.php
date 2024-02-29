<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Concerns\RespondWithToken;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class RefreshLoginController extends Controller
{
    use RespondWithToken;

    /**
     * Handle the incoming request.
     * 
     * @param  \App\Http\Requests\Auth\LoginAttemptRequest $request
     * @param  \Tymon\JWTAuth\JWTGuard $guard
     */
    public function __invoke(Request $request, Guard $guard)
    {
        return $this->respondWithToken($guard->refresh(), $guard);
    }
}
