<?php

namespace App\Http\Controllers\JsonApiAuth\Revokers;

use App\Http\Controllers\JsonApiAuth\Actions\AuthKit;
use Illuminate\Support\Facades\Auth;

class RevokerFactory
{
    public function make()
    {
        if(AuthKit::isSanctum()) {
            return new SanctumRevoker(Auth::user());
        }

        return new PassportRevoker(Auth::user());
    }
}
