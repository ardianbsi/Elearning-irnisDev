<?php

namespace App\Http\Requests;

use App\Models\StudyProgram;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudyProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', StudyProgram::class) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\StudyProgram|null $program */
        $program = $this->route('study_program');

        return [
            'faculty_id' => ['required', 'exists:faculties,id'],
            'code' => ['required', 'string', 'max:20', Rule::unique('study_programs', 'code')->ignore($program?->id)],
            'name' => ['required', 'string', 'max:255'],
            'degree' => ['nullable', 'string', 'max:20'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'faculty_id.required' => 'Fakultas wajib dipilih.',
            'faculty_id.exists' => 'Fakultas tidak ditemukan.',
            'code.required' => 'Kode prodi wajib diisi.',
            'code.unique' => 'Kode prodi sudah digunakan.',
            'name.required' => 'Nama prodi wajib diisi.',
        ];
    }
}
