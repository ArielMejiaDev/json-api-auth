<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {

        $user = Auth::user();

        $this->{$this->methodToApply()}($user);

        return Response([
            'message' => 'You are successfully logged out',
        ], 200);
    }

    protected function methodToApply()
    {
        $methods = [
            'revoke_only_current_token',
            'revoke_all_tokens',
            'delete_all_tokens',
        ];

        foreach ($methods as $method) {
            if(config('json-api-auth.' . $method)) {
                return (string) Str::of($method)->camel();
            }
        }

        return (string) Str::of($methods[2])->camel();
    }

    protected function revokeOnlyCurrentToken(User $user)
    {
        $user->token()->revoke();
    }

    protected function revokeAllTokens(User $user)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->update([
                'revoked' => true
            ]);
    }

    protected function deleteAllTokens(User $user)
    {
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }
}
