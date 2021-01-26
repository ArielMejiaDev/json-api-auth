<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\JsonApiAuth\NewPasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(NewPasswordRequest $request)
    {
        $user = $request->getUser($request);

        $user->update(['password' => Hash::make($request->get('password'))]);

        DB::table('password_resets')->where('email', $user->email)->delete();

        return response()->json([
            'message' => __('json-api-auth.password_updated'),
        ]);
    }


}
