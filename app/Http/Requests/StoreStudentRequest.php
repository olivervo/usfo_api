<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255', 'unique:students,id_number'],
            'address_1' => ['nullable', 'string'],
            'address_2' => ['nullable', 'string'],
            'zipcode' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date_format:Y-m-d', 'before:today'],
            'sex' => ['required', 'string', 'in:male,female,other'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'id_number.required' => 'ID number is required.',
            'id_number.unique' => 'This ID number is already registered.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date_format' => 'Date of birth must be in Y-m-d format (e.g., 2000-01-15).',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'sex.required' => 'Sex is required.',
            'sex.in' => 'Sex must be one of: male, female, other.',
        ];
    }
}
