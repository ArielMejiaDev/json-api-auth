<?php

namespace App\Http\Requests\JsonApiAuth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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

    public function getEmail()
    {
        $email = $this->get('email');

        if(User::where('email', $email)->doesntExist()) {
            return response()->json([
                'message' => 'User does not exists',
            ], 404);
        }

        return $email;
    }

    public function getNotificationEndpoint()
    {
        if(! $endpoint = config('json-api-auth.new_password_form_frontend_endpoint_url')) {
            throw ValidationException::withMessages([
                'message' => 'There is no domain set in config/json-api-auth.php as new_password_form_url, please add a frontend endpoint to send email with the link.'
            ]);
        }
        return $endpoint;
    }
}
