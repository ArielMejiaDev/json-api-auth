<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {

            if(Auth::attempt($request->only(['email', 'password']))) {
                return $this->returnCredentials();
            }

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }

        return response()->json([
            'message' => __('auth.failed'),
        ], 401);

    }

    private function returnCredentials()
    {
        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('app')->accessToken;

        return response()->json([
            'message' => 'success',
            'access_token' => $token,
            'user' => $user,
        ], 200);

    }
}
