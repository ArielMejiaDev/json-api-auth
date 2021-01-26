<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\JsonApiAuth\PasswordResetLinkRequest;
use App\Models\User;
use App\Notifications\JsonApiAuth\ResetPasswordNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{

    /**
     * @param PasswordResetLinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(PasswordResetLinkRequest $request)
    {
        $user = $request->getUser();

        try {
            // Here you can customize the token length
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

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 400);
        }

    }
}
