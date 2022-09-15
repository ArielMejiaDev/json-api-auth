<?php

namespace App\Http\Requests\JsonApiAuth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasswordResetLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::exists(User::class)],
        ];
    }

    public function getUserByEmail()
    {
        $email = $this->get('email');

        return User::query()->where('email', $email)->first();
    }
}
