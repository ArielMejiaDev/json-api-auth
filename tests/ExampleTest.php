<?php

namespace ArielMejiaDev\JsonApiAuth\Tests;

use Orchestra\Testbench\TestCase;
use ArielMejiaDev\JsonApiAuth\JsonApiAuthServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [JsonApiAuthServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
