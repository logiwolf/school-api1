<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('students')->where(
                    fn($query) =>
                    $query->where('birthdate', $this->birthdate)
                ),
            ],
            'email' => 'required|email|unique:students,email',
            'birthdate' => 'required|date',
            'grade' => 'required|string|max:50',
        ];
    }
}
