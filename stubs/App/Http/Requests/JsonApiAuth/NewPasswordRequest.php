<?php

namespace App\Http\Requests\JsonApiAuth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class NewPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
        ];
    }

    public function getUserByToken()
    {

        $token = $this->get('token');

        $passwordResets = DB::table('password_resets')->where('token', $token)->first();

        $this->validateToken($passwordResets);

        $user = User::firstWhere('email', $passwordResets->email);

        $this->validateUser($user);

        return $user;

    }

    public function validateToken($passwordResets)
    {
        if(! $passwordResets) {
            throw ValidationException::withMessages([
                'token' => 'invalid token',
            ]);
        }

        if(Carbon::createFromTimeString($passwordResets->created_at)->diffInMinutes(now()) >= 60) {
            throw ValidationException::withMessages([
                'token' => 'expired token',
            ]);
        }
    }

    public function validateUser(User $user)
    {
        if(! $user) {
            throw ValidationException::withMessages([
                'email' => 'User does not exists',
            ]);
        }

        if($this->get('email') !== $user->email) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email',
            ]);
        }
    }
}
