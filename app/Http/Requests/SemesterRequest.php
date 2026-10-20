<?php

namespace App\Http\Requests;

use App\Models\Semester;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Semester::class) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\Semester|null $semester */
        $semester = $this->route('semester');

        return [
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'term_code' => [
                'required', 'string', 'max:20',
                Rule::unique('semesters')->where(fn ($q) => $q->where('academic_year_id', $this->input('academic_year_id')))->ignore($semester?->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'academic_year_id.required' => 'Tahun akademik wajib dipilih.',
            'term_code.required' => 'Kode termin wajib diisi.',
            'term_code.unique' => 'Termin ini sudah ada pada tahun akademik tersebut.',
            'name.required' => 'Nama semester wajib diisi.',
            'ends_at.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }
}
