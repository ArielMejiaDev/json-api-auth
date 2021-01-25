<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Actions\JsonApiAuth\AuthKit;
use App\Notifications\JsonApiAuth\VerifyEmailNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class EmailVerificationNotificationController extends Controller
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
            return response(['message'=>'Already verified']);
        }

        $request->user(AuthKit::getGuard())->notify(new VerifyEmailNotification);

        return response()->json([
            'message' => 'Email Sent',
        ], 200);
    }


}
