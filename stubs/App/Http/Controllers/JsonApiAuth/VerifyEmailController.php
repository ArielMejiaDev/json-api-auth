<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Requests\JsonApiAuth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController
{
    /**
     * Mark the authenticated user's email address as verified.
     * Just take in mind that the request needs to go directly to the server to validate the id and token
     * Because the link would be sent on the email notification
     *
     * @param EmailVerificationRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            // if block added only to test on postman.
            if($request->wantsJson()) {
                return response()->json([
                    'message' => __('json-api-auth.email_already_verified'),
                ], 200);
            }
            return redirect()->to(config('json-api-auth.email_account_was_already_verified_url'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // if block added just to test on postman.
        if($request->wantsJson()) {
            return response()->json([
                'message' => __('json-api-auth.email_verified'),
            ], 200);
        }
        return redirect()->to(config('json-api-auth.email_account_just_verified_url'));
    }
}
