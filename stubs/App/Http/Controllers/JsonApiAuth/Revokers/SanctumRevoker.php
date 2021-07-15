<?php

namespace App\Http\Controllers\JsonApiAuth\Revokers;

use App\Http\Controllers\JsonApiAuth\Interfaces\Revoker;
use App\Models\User;

class SanctumRevoker implements Revoker
{
    private User $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * It revokes by updating only the token in database, that is given when user do a login.
     */
    public function revokeOnlyCurrentToken()
    {
        return $this->deleteCurrentToken();
    }

    /**
     * It revoke by updating all tokens of the user when user logout, it keeps them on database.
     */
    public function revokeAllTokens()
    {
        return $this->deleteAllTokens();
    }

    /**
     * It deletes the current token in database, the token deleted is the one used by the user use to login.
     */
    public function deleteCurrentToken()
    {
        return $this->user->currentAccessToken()->delete();
    }

    /**
     * It deletes all tokens in database used by the user when user logout.
     */
    public function deleteAllTokens()
    {
        $this->user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }
}
