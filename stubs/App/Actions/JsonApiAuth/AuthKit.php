<?php

namespace App\Actions\JsonApiAuth;

class AuthKit
{
    const PASSPORT_AUTH_KIT = 'passport';
    const SANCTUM_AUTH_KIT = 'sanctum';

    public static function getMiddleware()
    {
        if(config('json-api-auth.authentication_kit') === self::SANCTUM_AUTH_KIT) {
            return 'auth:sanctum';
        }

        return 'auth:api';
    }

    public static function getGuard()
    {
        if(static::isSanctum()) {
            return 'sanctum';
        }

        return 'api';
    }

    public static function isPassport()
    {
        if(config('json-api-auth.authentication_kit') === self::PASSPORT_AUTH_KIT) {
            return true;
        }
        return false;
    }

    public static function isSanctum()
    {
        if(config('json-api-auth.authentication_kit') === self::SANCTUM_AUTH_KIT) {
            return true;
        }
        return false;
    }
}
