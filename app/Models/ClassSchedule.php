<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = [
        'class_id',
        'hari',
        'start_time',
        'end_time',
        'room_id',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function classSchedule()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function lectureAssignments()
    {
        return $this->hasMany(ClassLecturer::class, 'course_class_id');
    }

    public function scopeHari($query, string $hari = null)
    {
        if ($hari) {
            $query->where('hari', $hari);
        }

        return $query;
    }

    public function scopeSeman($query, Semester $semester = null)
    {
        if ($semester) {
            $query->whereHas('classSchedule', function ($q) use ($semester) {
                $q->where('semester_id', $semester->id);
            });
        }

        return $query;
    }
}
