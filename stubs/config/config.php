<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Json Api Authentication Register Configuration
    |--------------------------------------------------------------------------
    |
    | This value is used to instruct the package if the user would be
    | authenticated after a successful user registration to return
    | to return the JWT token with the response.
    |
    */

    'authenticate_after_register' => false,

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

    'delete_all_tokens' => true,

];
