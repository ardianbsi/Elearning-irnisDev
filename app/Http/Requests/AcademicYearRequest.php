<?php

namespace App\Http\Requests;

use App\Models\AcademicYear;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', AcademicYear::class) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\AcademicYear|null $year */
        $year = $this->route('academic_year');

        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('academic_years', 'code')->ignore($year?->id)],
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
            'code.required' => 'Kode tahun akademik wajib diisi.',
            'code.unique' => 'Kode tahun akademik sudah digunakan.',
            'name.required' => 'Nama tahun akademik wajib diisi.',
            'ends_at.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }
}
