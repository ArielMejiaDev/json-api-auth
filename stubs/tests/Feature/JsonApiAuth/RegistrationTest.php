<?php

namespace Tests\Feature\JsonApiAuth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $passport = 'Laravel\Passport\Passport';
        if (class_exists($passport)) {
            Artisan::call('passport:install',['-vvv' => true]);
            \Laravel\Passport\Passport::actingAs($this->user);
        }
        $sanctum = 'Laravel\Sanctum\Sanctum';
        if (class_exists($sanctum)) {
            \Laravel\Sanctum\Sanctum::actingAs($this->user);
        }
    }

    public function test_registration_screen_can_be_rendered()
    {
        $this->assertTrue(Route::has('json-api-auth.register'));
    }

    public function test_new_users_can_register()
    {
        $response = $this->post(route('json-api-auth.register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();

        $response->assertSee([
            'message' => __('json-api-auth.success'),
        ]);
    }
}
