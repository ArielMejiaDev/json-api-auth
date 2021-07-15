<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\JsonApiAuth\Actions\AuthKit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController
{
    /** Confirm the user's password.*/
    public function __invoke(Request $request): JsonResponse
    {
        if (! Hash::check($request->get('password'), $request->user(AuthKit::getGuard())->password)) {
            throw ValidationException::withMessages([
                'password' => __('json-api-auth.password'),
            ]);
        }

        return response()->json([
            'message' => __('json-api-auth.password_confirmed'),
        ], 200);
    }
}
