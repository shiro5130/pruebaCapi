<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phones' => 'array',
            'phones.*' => 'string',
            'emails' => 'array',
            'emails.*' => 'string|email',
            'addresses' => 'array',
            'addresses.*.street' => 'string|max:255',
            'addresses.*.city' => 'string|max:255',
            'addresses.*.state' => 'string|max:255',
            'addresses.*.postal_code' => 'string|max:20',
        ];
    }
    
    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'emails.*.email' => 'Cada correo electrónico debe tener un formato válido.',

        ];
    }
}
