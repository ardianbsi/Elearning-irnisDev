<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataProfileTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->role(UserRole::AdminAcademic)->create();
    }

    public function test_profil_mahasiswa_nim_unik_dan_terikat_user(): void
    {
        $admin = $this->admin();
        $user = User::factory()->role(UserRole::Student)->create();
        $program = StudyProgram::factory()->create();

        $this->actingAs($admin)->post('/admin/students', [
            'user_id' => $user->id,
            'study_program_id' => $program->id,
            'nim' => '2024001001',
            'cohort' => '2024',
        ])->assertRedirect();
        $this->assertDatabaseHas('students', ['nim' => '2024001001', 'user_id' => $user->id]);

        // NIM sama ditolak
        $user2 = User::factory()->role(UserRole::Student)->create();
        $this->actingAs($admin)->post('/admin/students', [
            'user_id' => $user2->id,
            'nim' => '2024001001',
        ])->assertSessionHasErrors('nim');

        // User yang sama tidak bisa punya 2 profil
        $this->actingAs($admin)->post('/admin/students', [
            'user_id' => $user->id,
            'nim' => '2024001002',
        ])->assertSessionHasErrors('user_id');

        $student = Student::where('nim', '2024001001')->first();
        $this->assertEquals($user->id, $student->user->id);
        $this->assertEquals($program->id, $student->studyProgram->id);
    }

    public function test_profil_dosen_nip_unik_dan_terikat_user(): void
    {
        $admin = $this->admin();
        $user = User::factory()->role(UserRole::Lecturer)->create();

        $this->actingAs($admin)->post('/admin/lecturers', [
            'user_id' => $user->id,
            'nip' => '198001012005011001',
            'position' => 'Lektor',
        ])->assertRedirect();
        $this->assertDatabaseHas('lecturers', ['nip' => '198001012005011001']);

        $user2 = User::factory()->role(UserRole::Lecturer)->create();
        $this->actingAs($admin)->post('/admin/lecturers', [
            'user_id' => $user2->id,
            'nip' => '198001012005011001',
        ])->assertSessionHasErrors('nip');

        $lecturer = Lecturer::where('nip', '198001012005011001')->first();
        $this->assertEquals($user->id, $lecturer->user->id);
    }
}
