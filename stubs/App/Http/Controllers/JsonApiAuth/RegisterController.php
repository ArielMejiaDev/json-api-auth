<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\JsonApiAuth\Traits\HasToShowApiTokens;
use App\Http\Requests\JsonApiAuth\RegisterRequest;
use App\Notifications\JsonApiAuth\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    use HasToShowApiTokens;

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request)
    {
        try {

            /** @var User $user */
            $user = User::create([
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
