<?php

namespace App\Http\Requests\ScheduleConflict;

use App\Models\CourseClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateScheduleConflictsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', CourseClass::class) ?? false;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $courseClass = $this->route('course_class');

        return [
            'hari' => ['required', 'string', 'max:20'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'class_id' => ['nullable', 'exists:course_classes,id'],
            'lecturer_id' => ['nullable', 'exists:lecturers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'start_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ];
    }
}
