<?php

namespace App\Http\Requests\JsonApiAuth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PasswordResetLinkRequest extends FormRequest
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
            'email' => 'required|email',
        ];
    }

    public function getUser()
    {
        $email = $this->get('email');

        if(User::where('email', $email)->doesntExist()) {
            return response()->json([
                'message' => 'User does not exists',
            ], 404);
        }

        return User::whereEmail($email)->first();
    }
}
