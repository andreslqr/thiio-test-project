<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterAttemptRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterAttemptRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        return UserResource::make($user)
                        ->response()
                        ->setStatusCode(201);
    }
}
