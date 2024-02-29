<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Concerns\RespondWithToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAttemptRequest;
use Illuminate\Contracts\Auth\Guard;

class LoginController extends Controller
{
    use RespondWithToken;

    /**
     * Handle the incoming request.
     * 
     * @param  \App\Http\Requests\Auth\LoginAttemptRequest $request
     * @param  \Tymon\JWTAuth\JWTGuard $guard
     */
    public function __invoke(LoginAttemptRequest $request, Guard $guard)
    {
        $credentials = $request->safe()->only([
            'email',
            'password'
        ]);

        $token = $guard->attempt($credentials);

        return $this->respondWithToken($token, $guard);
    }
}
