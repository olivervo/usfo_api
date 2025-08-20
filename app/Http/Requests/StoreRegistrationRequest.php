<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer'],
            'camp_id' => ['required', 'integer'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'phone'],
            'email' => ['required', 'email', 'max:255'],
            'address_1' => ['required', 'string'],
            'zipcode' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'size:2'],
            'date_of_birth' => ['required', 'date_format:Y-m-d', 'before:today'],
            'allergies' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'dietary_restrictions' => ['nullable', 'string'],
            'sex' => ['required', 'string', 'in:male,female,other'],
        ];
    }
}
