<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'course_class_id',
        'student_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
