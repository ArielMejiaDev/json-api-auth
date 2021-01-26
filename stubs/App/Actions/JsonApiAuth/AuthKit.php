<?php

namespace App\Actions\JsonApiAuth;

class AuthKit
{
    const PASSPORT_AUTH_KIT = 'passport';
    const SANCTUM_AUTH_KIT = 'sanctum';

    public static function getMiddleware()
    {
        if(static::isSanctum()) {
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
        $passportVendorName = 'Laravel\Passport\Passport';
        if (class_exists($passportVendorName)) {
            return true;
        }
        return false;
    }

    public static function isSanctum()
    {
        $sanctumVendorName = 'Laravel\Sanctum\Sanctum';
        if(class_exists($sanctumVendorName)) {
            return true;
        }
        return false;
    }
}
