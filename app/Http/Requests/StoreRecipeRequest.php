<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'title' => ['required', 'max:100'],
            'summary' => ['required'],
            'ingredients' => ['required'],
            'instruction' => ['required'],
            'is_draft' => 'boolean',
            'video_url' => ['sometimes', 'nullable', 'url'],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,JPG,PNG,JPEG,WEBP','max:2048'],
            'private' => 'boolean'
        ];
    }
}
