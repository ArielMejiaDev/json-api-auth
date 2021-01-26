<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JsonApiAuth\Revokers\RevokerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class LogoutController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        (new RevokerFactory)->make()->{$this->applyRevokeStrategy()}();

        return Response([
            'message' => __('json-api-auth.logout'),
        ], 200);
    }

    /**
     * It guess what method is going to use on logout based on the package config file
     * @return string
     */
    public function applyRevokeStrategy()
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
