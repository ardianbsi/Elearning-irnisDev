<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Course::class) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\Course|null $course */
        $course = $this->route('course');

        return [
            'study_program_id' => ['nullable', 'exists:study_programs,id'],
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($course?->id)],
            'name' => ['required', 'string', 'max:255'],
            'credits' => ['required', 'integer', 'min:0', 'max:12'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Kode mata kuliah wajib diisi.',
            'code.unique' => 'Kode mata kuliah sudah digunakan.',
            'name.required' => 'Nama mata kuliah wajib diisi.',
            'credits.required' => 'SKS wajib diisi.',
            'credits.max' => 'SKS maksimal 12.',
        ];
    }
}
