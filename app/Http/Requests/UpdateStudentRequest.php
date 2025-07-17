<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('students')->where(
                    fn($query) =>
                    $query->where('birthdate', $this->birthdate)
                )->ignore($this->student->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($this->student->id),
            ],
            'birthdate' => 'required|date',
            'grade' => 'required|string|max:50',
        ];
    }
}
