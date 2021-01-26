<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Actions\JsonApiAuth\AuthKit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController
{
    /**
     * Confirm the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
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
