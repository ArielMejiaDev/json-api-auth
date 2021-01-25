<?php

namespace App\Http\Controllers\JsonApiAuth\Revokers;

use App\Actions\JsonApiAuth\AuthKit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
