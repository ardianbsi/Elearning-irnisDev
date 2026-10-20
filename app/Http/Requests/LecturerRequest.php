<?php

namespace App\Http\Requests;

use App\Models\Lecturer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LecturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Lecturer::class) ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\Lecturer|null $lecturer */
        $lecturer = $this->route('lecturer');

        $userRule = $lecturer
            ? Rule::unique('lecturers', 'user_id')->ignore($lecturer->id)
            : ['required', 'unique:lecturers,user_id', 'exists:users,id'];

        return [
            'user_id' => is_array($userRule) ? $userRule : ['required', $userRule],
            'faculty_id' => ['nullable', 'exists:faculties,id'],
            'nip' => ['required', 'string', 'max:30', Rule::unique('lecturers', 'nip')->ignore($lecturer?->id)],
            'position' => ['nullable', 'string', 'max:255'],
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
            'user_id.unique' => 'Akun ini sudah memiliki profil dosen.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',
        ];
    }
}
