<?php

namespace App\Notifications\JsonApiAuth;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
//        if (static::$createUrlCallback) {
//            return call_user_func(static::$createUrlCallback, $notifiable);
//        }

        return URL::temporarySignedRoute(
            'json-api-auth.verification.verify',
            // here you can customize the email verification link expiration time in minutes
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}

