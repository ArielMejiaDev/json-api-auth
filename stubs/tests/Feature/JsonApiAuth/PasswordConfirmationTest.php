<?php

namespace Tests\Feature\JsonApiAuth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
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

    public function test_confirm_password_endpoint_is_available()
    {
        $this->assertTrue(Route::has('json-api-auth.password.confirm'));
    }

    public function test_password_can_be_confirmed()
    {
        $response = $this->postJson(route('json-api-auth.password.confirm'), [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertSee([
            'message' => __('json-api-auth.password_confirmed')
        ]);
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {

        $response = $this->actingAs($this->user)->postJson(route('json-api-auth.password.confirm'), [
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson([
            'errors' => [
                'password' => []
            ]
        ]);
    }
}
