<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\JsonApiAuth\EmailVerificationRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
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
            // added just to test on postman (See the method Docblock to get more info).
            if($request->wantsJson()) {
                return response()->json([
                    'message' => 'Email is already verified',
                ], 200);
            }
            return redirect()->to(config('json-api-auth.email_account_already_verified_frontend_endpoint_url'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // added just to test on postman (See the method Docblock to get more info).
        if($request->wantsJson()) {
            return response()->json([
                'message' => 'Email verified',
            ], 200);
        }
        return redirect()->to(config('json-api-auth.email_account_just_verified_frontend_endpoint_url'));
    }
}
