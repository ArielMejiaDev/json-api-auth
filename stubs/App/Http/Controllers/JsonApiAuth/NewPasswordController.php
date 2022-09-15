<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Requests\JsonApiAuth\NewPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NewPasswordController
{
    /** Handle an incoming new password request. */
    public function __invoke(NewPasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->getUserByToken();

        $user->update(['password' => Hash::make($request->get('password'))]);

        DB::table('password_resets')->where('email', $user->email)->delete();

        return response()->json([
            'message' => __('json-api-auth.password_updated'),
        ]);
    }
}
