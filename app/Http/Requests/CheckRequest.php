<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckRequest extends FormRequest
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
            'name' => ['required', 'max:16'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Поле названия карточки обязательно!!!',
            'name.max' => 'Поле название карточки не должно привышать 16 символов!!!',
        ];
    }
}
