<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Json Api Authentication Show Token After Registration
    |--------------------------------------------------------------------------
    |
    | This value is used to instruct the package if the user would be
    | Authenticated after a successful user registration
    | To return the JWT token with the response.
    |
    */

    'show_token_after_register' => true,

    /*
    |--------------------------------------------------------------------------
    | Json Api Authentication Logout Configuration
    |--------------------------------------------------------------------------
    |
    | This value is used to instruct the package the behavior with tokens
    | Revoke only the token from the request, revoke all tokens or delete them
    | You should only add one value as true, if all are false the default action
    | Would be to delete all tokens.
    |
    */

    'revoke_only_current_token' => false,

    'revoke_all_tokens' => false,

    'delete_current_token' => false,

    'delete_all_tokens' => true,

    /*
    |--------------------------------------------------------------------------
    | Json Api Forgot Password Configuration
    |--------------------------------------------------------------------------
    |
    | This value is used to instruct the package the url for the notification
    | This would be a page of your frontend new password form.
    | Its not related to any backend route take that in mind.
    |
    */

    'new_password_form_url' =>  env('FRONTEND_APP_URL', 'http://frontend.test') .'/new-password',

    /*
    |--------------------------------------------------------------------------
    | Json Api Authentication Token id Configuration
    |--------------------------------------------------------------------------
    |
    | This value is used to create tokens in Login and Register features
    |
    */

    'token_id' => 'App',

    /*
    |--------------------------------------------------------------------------
    | Json Api Authentication Scopes
    |--------------------------------------------------------------------------
    |
    | Passport & Sanctum use scopes to validate abilities,
    | Optionally you can add scopes here, that would be added on Login and register
    |
    */

    'scopes' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Json Api Authentication Frontend Endpoints Of Verify Email Feature
    |--------------------------------------------------------------------------
    |
    | This values are used to redirect user when email verified validation pass
    | First one is use to redirect users if email account its already verified
    | Second is use to redirect users if email account its verified at that moment
    |
    */

    'email_account_was_already_verified_url' =>  env('FRONTEND_APP_URL', 'http://frontend.test') . '/already-verified',

    'email_account_just_verified_url' => env('FRONTEND_APP_URL', 'http://frontend.test') . '/verified',

];
