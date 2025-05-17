<?php

namespace App\Http\Requests;

use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|alpha",
            "surname" => "required|string|alpha",
            "password" => ["required", Password::default()],
            "phone" => ["required", 'regex:/\+380\d{9}$/'],
            "email" => ["required", "email", new EmailRule],
            "contacts" => "string|min:10|max:50",
            "image_base64" => "string|max:60000",
            "addresses" => "string",
        ];
    }
}
