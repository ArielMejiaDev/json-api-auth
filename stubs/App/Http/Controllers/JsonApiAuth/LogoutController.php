<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\JsonApiAuth\Revokers\RevokerFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class LogoutController
{
    public function __invoke(Request $request): Response
    {
        (new RevokerFactory)->make()->{$this->applyRevokeStrategy()}();

        return response([
            'message' => __('json-api-auth.logout'),
        ], 200);
    }

    /** It guess what method is going to use on logout based on the package config file. */
    public function applyRevokeStrategy(): string
    {
        $methods = [
            'revoke_only_current_token',
            'revoke_all_tokens',
            'delete_current_token',
            'delete_all_tokens',
        ];

        foreach ($methods as $method) {
            if(config('json-api-auth.' . $method)) {
                return (string) Str::of($method)->camel();
            }
        }

        return (string) Str::of($methods[3])->camel();
    }
}
