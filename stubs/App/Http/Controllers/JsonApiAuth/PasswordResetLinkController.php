<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\JsonApiAuth\PasswordResetLinkRequest;
use App\Models\User;
use App\Notifications\JsonApiAuth\ForgotPasswordNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{

    public function __invoke(PasswordResetLinkRequest $request)
    {
        $email = $request->getEmail();

        try {
            $token = Str::random(60);

            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]);

            Notification::route('mail', $email)
                ->notify(new ForgotPasswordNotification($request->getNotificationEndpoint(), $token));

            return response()->json([
                'message' => 'check your email',
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 400);
        }

    }
}
