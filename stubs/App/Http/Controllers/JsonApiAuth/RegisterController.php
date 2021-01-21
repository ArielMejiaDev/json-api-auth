<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        try {

            /** @var User $user */
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $data = ['user' => $user];

            if(config('json-api-auth.authenticate_after_register')) {
                Auth::login($user);
                $data['access_token'] = $user->createToken('app')->accessToken;
            }

            event(new Registered($user));

            if($user instanceof MustVerifyEmail) {
                $user->sendEmailVerificationNotification();
            }

            return response()->json($data, 201);

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }
}
