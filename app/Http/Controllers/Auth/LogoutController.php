<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @param  \App\Http\Requests\Auth\LoginAttemptRequest $request
     * @param  \Tymon\JWTAuth\JWTGuard $guard
     */
    public function __invoke(Request $request, Guard $guard)
    {
        $guard->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
