<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Room;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->role(UserRole::AdminAcademic)->create();
    }

    public function test_crud_prodi_dengan_relasi_fakultas(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/study-programs', [
            'faculty_id' => \App\Models\Faculty::factory()->create()->id,
            'code' => 'TI',
            'name' => 'Teknik Informatika',
            'degree' => 'S1',
        ])->assertRedirect();
        $this->assertDatabaseHas('study_programs', ['code' => 'TI']);

        // Duplikat kode ditolak
        $this->actingAs($admin)->post('/admin/study-programs', [
            'faculty_id' => \App\Models\Faculty::factory()->create()->id,
            'code' => 'TI',
            'name' => 'Duplikat',
        ])->assertSessionHasErrors('code');
    }

    public function test_crud_tahun_akademik_dan_semester_unik_per_tahun(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/academic-years', [
            'code' => '2025/2026',
            'name' => 'Tahun Akademik 2025/2026',
            'starts_at' => '2025-08-01',
            'ends_at' => '2026-07-31',
        ])->assertRedirect();

        $year = AcademicYear::where('code', '2025/2026')->first();
        $this->assertNotNull($year);

        $this->actingAs($admin)->post('/admin/semesters', [
            'academic_year_id' => $year->id,
            'term_code' => 'ganjil',
            'name' => 'Semester Ganjil',
        ])->assertRedirect();

        // Termin sama pada tahun sama ditolak
        $this->actingAs($admin)->post('/admin/semesters', [
            'academic_year_id' => $year->id,
            'term_code' => 'ganjil',
            'name' => 'Duplikat',
        ])->assertSessionHasErrors('term_code');
    }

    public function test_crud_matkul_dan_ruang_plus_toggle(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/courses', [
            'code' => 'MK-001',
            'name' => 'Pemrograman Web',
            'credits' => 3,
        ])->assertRedirect();
        $this->assertDatabaseHas('courses', ['code' => 'MK-001', 'credits' => 3]);

        $this->actingAs($admin)->post('/admin/rooms', [
            'code' => 'R-101',
            'name' => 'Ruang 101',
            'capacity' => 40,
        ])->assertRedirect();
        $this->assertDatabaseHas('rooms', ['code' => 'R-101']);

        $course = Course::where('code', 'MK-001')->first();
        $this->actingAs($admin)->post("/admin/courses/{$course->id}/toggle")->assertRedirect();
        $this->assertDatabaseHas('courses', ['code' => 'MK-001', 'is_active' => false]);
    }
}
