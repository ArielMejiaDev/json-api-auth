<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\JsonApiAuth\Actions\AuthKit;
use App\Notifications\JsonApiAuth\VerifyEmailNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailVerificationNotificationController
{
    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function __invoke(Request $request)
    {
        if ($request->user(AuthKit::getGuard())->hasVerifiedEmail()) {
            return response(['message'=> __('json-api-auth.email_already_verified')]);
        }

        $request->user(AuthKit::getGuard())->notify(new VerifyEmailNotification);

        return response()->json([
            'message' => __('json-api-auth.email_sent'),
        ], 200);
    }
}
