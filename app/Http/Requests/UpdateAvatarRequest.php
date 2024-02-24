<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
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
            'avatar' => ['mimes:png,jpg,jpeg,JPG,PNG,JPEG','max:2048']
        ];
    }

    public function messages():array
    {
        return [
            'avatar.max' => 'The avatar size must be maximum of :max.',
        ];
    }

}
