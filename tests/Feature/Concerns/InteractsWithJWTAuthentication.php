<?php

namespace Tests\Feature\Concerns;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

trait InteractsWithJWTAuthentication
{
    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string|null  $guard
     * @return $this
     */
    public function actingAs(UserContract $user, $guard = 'api')
    {
        $token = auth($guard)->login($user);

        $this->withHeaders(
            array_merge([
                $this->defaultHeaders,
                ['Authorization' => "Bearer {$token}"]
            ])
        );

        return $this;
    }
}