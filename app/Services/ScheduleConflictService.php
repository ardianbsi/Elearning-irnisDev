<?php

namespace App\Services\ScheduleConflict;

use App\Models\ClassSchedule;
use App\Models\CourseClass;
use App\Models\Lecturer;
use App\Models\Room;
use Exception;

class ScheduleConflictService
{
    /** @var array<int, mixed> */
    protected array $errors = [];

    public function validate(
        string $hari,
        string $startTime,
        string $endTime,
        ?int $roomId,
        ?int $courseClassId,
        ?int $lecturerId,
        int $enrollmentCount
    ): array {
        $this->errors = [];

        if ($this->roomConflicts($roomId, $courseClassId, $hari, $startTime, $endTime)) {
            $this->errors[] = 'Ruang sudah dipakai pada jam yang sama.';
        }

        if ($this->lecturerConflicts($lecturerId, $courseClassId)) {
            $this->errors[] = 'Dosen sudah mengajar kelas lain pada waktu yang sama.';
        }

        if ($enrollmentCount > 0 && $this->enrolledStudentConflict($courseClassId)) {
            $this->errors[] = 'Masyarakat sudah ada mahasiswa terdaftar di kelas ini.';
        }

        return $this->errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function clear(): void
    {
        $this->errors = [];
    }

    public function roomConflicts(?int $roomId, ?int $courseClassId, string $hari, string $startTime, string $endTime): bool
    {
        if ($roomId === null) {
            return false;
        }

        $overlaps = ClassSchedule::where('room_id', $roomId)
            ->where('hari', $hari)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                    });
            })
            ->when($courseClassId, fn ($q) => $q->where('id', '!=', $courseClassId))
            ->exists();

        if ($overlaps) {
            return true;
        }

        $this->checkDuplicateSchedule($roomId, $hari, $startTime, $endTime);

        return false;
    }

    public function lecturerConflicts(?int $lecturerId, ?int $courseClassId): bool
    {
        if ($lecturerId === null) {
            return false;
        }

        $overlaps = ClassSchedule::whereHas('class', function ($q) use ($lecturerId) {
            $q->whereHas('lectureAssignments', function ($q) use ($lecturerId) {
                $q->where('lecturer_id', $lecturerId);
            });
        })
            ->where(function ($query) use ($lecturerId) {
                $query->whereRaw('TIME(start_time) <= TIME(?)', [$lecturerId])
                    ->whereRaw('TIME(end_time) >= TIME(?)', [$lecturerId]);
            })
            ->when($courseClassId, fn ($q) => $q->where('id', '!=', $courseClassId))
            ->exists();

        if ($overlaps) {
            return true;
        }

        $this->checkDuplicateLecturer($lecturerId, $courseClassId);

        return false;
    }

    public function enrolledStudentConflict(int $courseClassId): bool
    {
        return (bool) CourseClass::find($courseClassId)?->students->isNotEmpty();
    }

    public function validateForCreate(
        string $hari,
        string $startTime,
        string $endTime,
        ?int $roomId,
        ?int $classId,
        ?int $lecturerId,
        int $enrollmentCount
    ): array {
        $this->clear();
        $this->validate($hari, $startTime, $endTime, $roomId, $classId, $lecturerId, $enrollmentCount);

        return $this->getErrors();
    }

    protected function checkDuplicateSchedule(?int $roomId, string $hari, string $startTime, string $endTime): void
    {
        $existing = ClassSchedule::where('room_id', $roomId)
            ->where('hari', $hari)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', $startTime)
                    ->where('end_time', $endTime);
            })
            ->exists();

        if ($existing) {
            $this->errors[] = $this->buildErrorMessage($roomId, $hari, $startTime, $endTime);
        }
    }

    protected function checkDuplicateLecturer(?int $lecturerId, ?int $courseClassId): void
    {
        if ($lecturerId === null) {
            return;
        }

        $existing = ClassSchedule::whereHas('class.lectureAssignments', function ($q) use ($lecturerId) {
            $q->where('lecturer_id', $lecturerId);
        })
            ->when($courseClassId, fn ($q) => $q->where('id', '!=', $courseClassId))
            ->exists();

        if ($existing) {
            $this->errors[] = 'Dosen ini sudah ditugaskan pada kelas lain.';
        }
    }

    protected function buildErrorMessage(int $roomId, string $hari, string $startTime, string $endTime): string
    {
        $room = Room::find($roomId);

        return sprintf(
            'Jadwal ruangan "%s" sudah ada pada %s, %s-%s.',
            $room?->name ?? 'ruangan terpilih',
            $hari,
            $startTime,
            $endTime
        );
    }
}
