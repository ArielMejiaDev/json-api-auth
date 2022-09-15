<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Requests\JsonApiAuth\PasswordResetLinkRequest;
use App\Models\User;
use App\Notifications\JsonApiAuth\ResetPasswordNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetLinkController
{
    public function __invoke(PasswordResetLinkRequest $request): JsonResponse
    {
        $user = $request->getUserByEmail();
        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $user->notify(new ResetPasswordNotification($token));

        return response()->json([
            'message' => __('json-api-auth.check_your_email'),
        ]);

    }
}
