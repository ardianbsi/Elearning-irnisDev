<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\Faculty::class) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $faculty = $this->route('faculty');

        return [
            'code' => ['required', 'string', 'max:20', 'unique:faculties,code'.($faculty ? ','.$faculty->id : '')],
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Kode fakultas wajib diisi.',
            'code.unique' => 'Kode fakultas sudah digunakan.',
            'name.required' => 'Nama fakultas wajib diisi.',
        ];
    }
}
