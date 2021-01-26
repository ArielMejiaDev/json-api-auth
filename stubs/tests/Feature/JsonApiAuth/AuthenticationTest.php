<?php

namespace Tests\Feature\JsonApiAuth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $passport = 'Laravel\Passport\Passport';
        if (class_exists($passport)) {
            Artisan::call('passport:install',['-vvv' => true]);
        }
    }

    use RefreshDatabase;

    public function test_login_endpoint_its_available()
    {
        $this->assertTrue(Route::has('json-api-auth.login'));
    }

    public function test_users_can_authenticate_using_the_login_endpoint()
    {
        $user = User::factory()->create();

        $response = $this->post(route('json-api-auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response->assertSee([
            'message' => 'success',
        ]);

        $user->refresh();
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post(route('json-api-auth.login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
