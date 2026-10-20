<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class MasterDataAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{string}>
     */
    public static function adminUrls(): array
    {
        return [
            'faculties' => ['/admin/faculties'],
            'study-programs' => ['/admin/study-programs'],
            'academic-years' => ['/admin/academic-years'],
            'semesters' => ['/admin/semesters'],
            'courses' => ['/admin/courses'],
            'rooms' => ['/admin/rooms'],
            'students' => ['/admin/students'],
            'lecturers' => ['/admin/lecturers'],
        ];
    }

    #[DataProvider('adminUrls')]
    public function test_guest_ditolak_dari_halaman_admin(string $url): void
    {
        $this->get($url)->assertRedirect('/login');
    }

    #[DataProvider('adminUrls')]
    public function test_dosen_dan_mahasiswa_ditolak_403(string $url): void
    {
        foreach ([UserRole::Lecturer, UserRole::Student] as $role) {
            $user = User::factory()->role($role)->create();

            $this->actingAs($user)->get($url)->assertForbidden();
            auth()->logout();
        }
    }

    #[DataProvider('adminUrls')]
    public function test_admin_dan_superadmin_boleh_akses(string $url): void
    {
        foreach ([UserRole::Superadmin, UserRole::AdminAcademic] as $role) {
            $user = User::factory()->role($role)->create();

            $this->actingAs($user)->get($url)->assertOk();
            auth()->logout();
        }
    }

    public function test_admin_dapat_crud_fakultas(): void
    {
        $admin = User::factory()->role(UserRole::AdminAcademic)->create();

        // Create
        $this->actingAs($admin)->post('/admin/faculties', [
            'code' => 'FT',
            'name' => 'Fakultas Teknik',
        ])->assertRedirect();
        $this->assertDatabaseHas('faculties', ['code' => 'FT']);

        $faculty = Faculty::where('code', 'FT')->first();

        // Update
        $this->actingAs($admin)->put("/admin/faculties/{$faculty->id}", [
            'code' => 'FT',
            'name' => 'Fakultas Teknologi',
            'is_active' => true,
        ])->assertRedirect();
        $this->assertDatabaseHas('faculties', ['code' => 'FT', 'name' => 'Fakultas Teknologi']);

        // Toggle nonaktif
        $this->actingAs($admin)->post("/admin/faculties/{$faculty->id}/toggle")->assertRedirect();
        $this->assertDatabaseHas('faculties', ['code' => 'FT', 'is_active' => false]);
    }

    public function test_kode_duplikat_ditolak(): void
    {
        $admin = User::factory()->role(UserRole::AdminAcademic)->create();
        Faculty::factory()->create(['code' => 'FE']);

        $this->actingAs($admin)->post('/admin/faculties', [
            'code' => 'FE',
            'name' => 'Duplikat',
        ])->assertSessionHasErrors('code');
    }

    public function test_fakultas_terpakai_tidak_bisa_dihapus_via_policy(): void
    {
        $admin = User::factory()->role(UserRole::AdminAcademic)->create();
        $faculty = Faculty::factory()->create();
        \App\Models\StudyProgram::factory()->create(['faculty_id' => $faculty->id]);

        $this->assertFalse($admin->can('delete', $faculty));
    }
}
