<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JsonApiAuth\Traits\HasToShowApiTokens;
use App\Http\Requests\JsonApiAuth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use HasToShowApiTokens;

    public function __invoke(LoginRequest $request)
    {
        try {

            if(Auth::attempt($request->only(['email', 'password']))) {
                return $this->showCredentials(Auth::user());
            }

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'message' => __('json-api-auth.failed'),
        ], 401);

    }
}
