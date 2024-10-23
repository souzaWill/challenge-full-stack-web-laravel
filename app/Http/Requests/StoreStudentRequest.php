<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Student::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', "string", "max:255"],
            'email' => ['required', 'unique:users', 'email'],
            'document' => ['required', 'unique:students', "regex:/^\d{11}$/"],
            'registration_number' => ['required', 'unique:students', "regex:/^\d{8}$/"],
        ];
    }
}
