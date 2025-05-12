<?php

namespace App\Http\Requests;

use App\Rules\CategoryRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdvertisementRequest extends FormRequest
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
            "name" => "string|min:10|max:40",
            "description" => "string|min:10|max:500",
            "price" => "decimal:2",
            "categories" => "array|min:1",
            "categories.*" => ["numeric", "integer", new CategoryRule],
            "photos" => "array",
            "photos.*" => "url",
        ];
    }
}
