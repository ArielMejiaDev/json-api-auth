<?php

namespace ArielMejiaDev\JsonApiAuth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ArielMejiaDev\JsonApiAuth\Skeleton\SkeletonClass
 */
class JsonApiAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'json-api-auth';
    }
}
