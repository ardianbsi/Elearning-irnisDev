<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassLecturer extends Model
{
    protected $fillable = [
        'course_class_id',
        'lecturer_id',
    ];

    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
}
