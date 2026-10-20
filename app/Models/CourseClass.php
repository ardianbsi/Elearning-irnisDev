<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    use HasUuids;

    protected $fillable = [
        'course_id',
        'academic_year_id',
        'semester_id',
        'kelas',
        'kapasitas',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function classSchedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }

    public function lectureAssignments()
    {
        return $this->hasMany(ClassLecturer::class);
    }

    public function lecturers()
    {
        return $this->hasManyThrough(
            Lecturer::class,
            ClassLecturer::class,
            'course_class_id',
            'id'
        );
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'course_class_id',
            'id'
        );
    }
}
