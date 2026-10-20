<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Student::class) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\Student|null $student */
        $student = $this->route('student');

        $userRule = $student
            ? Rule::unique('students', 'user_id')->ignore($student->id)
            : ['required', 'unique:students,user_id', 'exists:users,id'];

        return [
            'user_id' => is_array($userRule) ? $userRule : ['required', $userRule],
            'study_program_id' => ['nullable', 'exists:study_programs,id'],
            'nim' => ['required', 'string', 'max:30', Rule::unique('students', 'nim')->ignore($student?->id)],
            'cohort' => ['nullable', 'string', 'max:10'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Akun pengguna wajib dipilih.',
            'user_id.unique' => 'Akun ini sudah memiliki profil mahasiswa.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
        ];
    }
}
