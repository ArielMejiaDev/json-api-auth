<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\JsonApiAuth\Traits\HasToShowApiTokens;
use App\Http\Requests\JsonApiAuth\RegisterRequest;
use App\Notifications\JsonApiAuth\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController
{
    use HasToShowApiTokens;

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {

            /** @var User $user */
            $user = User::query()->create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                $user->notify(new VerifyEmailNotification);
            }

            // You can customize on config file if the user would show token on register to directly register and login at once.
            return $this->showCredentials($user, 201, config('json-api-auth.show_token_after_register'));

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }
}
