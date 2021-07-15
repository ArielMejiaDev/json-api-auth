<?php

namespace App\Http\Controllers\JsonApiAuth\Revokers;

use App\Http\Controllers\JsonApiAuth\Interfaces\Revoker;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PassportRevoker implements Revoker
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
        $this->user->token()->revoke();
    }

    /**
     * It revoke by updating all tokens of the user when user logout, it keeps them on database.
     */
    public function revokeAllTokens()
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $this->user->id)
            ->update([
                'revoked' => true
            ]);
    }

    /**
     * It deletes the current token in database, the token deleted is the one used by the user use to login.
     * @return
     */
    public function deleteCurrentToken()
    {
        return $this->user->token()->delete();
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
