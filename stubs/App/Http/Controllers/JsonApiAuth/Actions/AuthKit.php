<?php

namespace App\Http\Controllers\JsonApiAuth\Actions;

class AuthKit
{
    const PASSPORT_AUTH_KIT = 'passport';
    const SANCTUM_AUTH_KIT = 'sanctum';

    public static function getGuard(): string
    {
        if(static::isSanctum()) {
            return 'sanctum';
        }

        return 'api';
    }

    public static function isPassport(): bool
    {
        $passportVendorName = 'Laravel\Passport\Passport';
        if (class_exists($passportVendorName)) {
            return true;
        }
        return false;
    }

    public static function isSanctum(): bool
    {
        $sanctumVendorName = 'Laravel\Sanctum\Sanctum';
        if(class_exists($sanctumVendorName)) {
            return true;
        }
        return false;
    }
}
