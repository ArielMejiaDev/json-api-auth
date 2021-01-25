<?php

namespace App\Http\Controllers\JsonApiAuth\Interfaces;

interface Revoker
{
    public function revokeOnlyCurrentToken();

    public function revokeAllTokens();

    public function deleteCurrentToken();

    public function deleteAllTokens();
}
