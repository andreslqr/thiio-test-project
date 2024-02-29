<?php

namespace App\Http\Controllers\Auth\Concerns;

trait RespondWithToken
{
    /**
     * Get a json response with the token
     * 
     * @param string $token
     * @param \Tymon\JWTAuth\JWTGuard $guard
     * @return \Illuminate\Http\Response
     */
    protected function respondWithToken($token, $guard)
    {
        return response()->json(([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60
        ]));
    }
}