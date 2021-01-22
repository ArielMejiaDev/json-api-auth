<?php

namespace App\Http\Controllers\JsonApiAuth\Traits;

trait HasToShowApiTokens
{
    public function showCredentials($user, $code = 200, $showToken = true)
    {
        $response = [
            'message' => 'success',
            'user' => $user,
        ];

        if($showToken) {
            $token = $user->createToken(
                config('json-api-auth.token_id'),
                config('json-api-auth.scopes')
            )->accessToken;

            $response['token'] = $token;
        }

        return response()->json($response, $code);
    }
}
