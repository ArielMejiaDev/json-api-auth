<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\JsonApiAuth\Traits\HasToShowApiTokens;
use App\Http\Requests\JsonApiAuth\RegisterRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    use HasToShowApiTokens;

    public function __invoke(RegisterRequest $request)
    {
        try {

            /** @var User $user */
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            event(new Registered($user));

            if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
            }

            return $this->showCredentials($user, 201, config('json-api-auth.show_token_after_register'));

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }
}
