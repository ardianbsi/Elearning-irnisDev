# HANDOFF STATE — MyCampus LMS

> AI coding agent: perbarui dokumen ini di akhir setiap fase. Jangan mengklaim pekerjaan selesai tanpa verifikasi.

## Current status
- Fase terakhir: Fase 2 — Master Data Akademik
- Status: Complete (46/46 tests lolos, 165 assertions)
- Tanggal: 2026-10-20
- Branch/commit (jika tersedia): master (commit Fase 2 menyusul)

## Repository baseline
- Laravel: v13.35.0 (syarat composer ^13.17)
- PHP: 8.4.26 CLI ZTS + OPcache — WAJIB pakai C:\laragon\bin\php\php-8.4.26-Win32-vs17-x64\php.exe (shell default 8.1.10 gagal platform_check)
- Composer: 2.4.1 (warning deprecation nullable di PHP 8.4, non-blocking)
- Node: v24.21.0
- Database: sqlite aktif (.env), migrasi Fase 1+2 Ran; pgsql tersedia via pdo_pgsql tapi belum dikonfigurasi
- UI stack: Blade + Tailwind ^4; Livewire v4 support L13 terverifikasi tapi DITUNDA (butuh izin install dependency)
- Test framework: PHPUnit ^12.5.12, phpunit.xml sqlite :memory:
- Auth: session guard web + enum UserRole + middleware role:* + Gates + 9 Policies

## Completed
- [x] Fase 0 — Audit
- [x] Fase 1 — Fondasi/Auth/UI (14/14 tests lolos)
- [x] Fase 2 — Master data (46/46 tests lolos)
- [ ] Fase 3 — Kelas/Enrollment/Jadwal
- [ ] Fase 4 — Pertemuan/Presensi
- [ ] Fase 5 — Materi
- [ ] Fase 6 — Diskusi
- [ ] Fase 7 — Tugas/Submission/Nilai
- [ ] Fase 8 — Pengumuman/Laporan
- [ ] Fase 9 — Kuliah pengganti
- [ ] Fase 10 — Hardening/Deployment

## Files changed
- Fase 2 (baru/diubah):
  - 7 migrasi: faculties, study_programs (FK restrict), academic_years, semesters (unique tahun+termin), courses, rooms, students+lecturers (user unique, NIM/NIP unique)
  - 8 model + relasi (User hasOne student/lecturer); base Controller pakai AuthorizesRequests (fix Laravel 13)
  - 9 Policies (AcademicPolicy induk + 8 spesifik; Faculty delete ditolak bila punya prodi)
  - 8 Form Requests (unique ignore, FK exists, tanggal konsisten, pesan id)
  - 8 Controllers Admin (index search/filter/pagination + eager loading, store/show/edit/update, toggle aktif; tanpa destroy)
  - routes/web.php grup admin role:superadmin,admin_academic + nav menu admin
  - 34 views: filter-form, 8 modul x index/create/edit/show
  - 8 factories; 3 file test (Authorization 24 dataset + CRUD + Profil)

## Database changes
- Migration dibuat: 2026_10_20_000001 s.d. 000007 (8 tabel).
- Migration dijalankan pada environment: dev lokal sqlite — semua DONE (batch 3).
- Data seeder: DemoUsersSeeder tetap (Fase 1).
- Catatan rollback: migrate:rollback menghapus 8 tabel master (FK restrict aman karena drop urutan terbalik).

## Tests
- Command: php8.4 vendor/bin/phpunit (via run-fase1-test.php, lalu dihapus)
- Hasil aktual: PASSED — 46 tests, 46 passed, 165 assertions, EXIT=0.
- Cakupan Fase 2: guest→login (8 URL), dosen/mahasiswa→403 (16 cek), admin/superadmin→200 (16 cek), CRUD fakultas+toggle, duplikat kode, policy delete fakultas terpakai, CRUD prodi/tahun/semester-unik/matkul/ruang, NIM+NIP unik, user tunggal per profil, relasi user/prodi.
- Bug yang diperbaiki saat verifikasi: (1) Controller::authorize() tak ada → trait AuthorizesRequests; (2) @dataProvider anotasi → atribut #[DataProvider]; (3) @include dengan $slot → tabel inline per view.

## Decisions
- Tanpa hard delete master data (hanya toggle is_active); FK restrictOnDelete untuk fakultas→prodi, tahun→semester.
- students/lecturers: user_id unique + cascadeOnDelete; NIM/NIP unique; user pengikat tak bisa diganti saat update.
- users sebagai akun login; nama/email tidak diduplikasi di profil (relasi user).
- Filter fakultas/prodi/tahun di index disederhanakan (hanya search q) agar include Blade valid; filter spesifik menyusul bila diminta.
- Artefak verifikasi (run-fase1-test.php, test-output.txt, junit*.xml, fase*-verify.txt) DIHAPUS sebelum commit.

## Known issues / blockers
- PostgreSQL dev belum setup (menunggu kredensial user); sqlite tetap untuk dev.
- Livewire ditunda; UI Blade murni.
- Reset password via log mail (dev).

## Next exact step
- Nama fase berikutnya: Fase 3 — Kelas, Dosen Pengampu, Enrollment, Jadwal
- Prompt/task terkecil yang harus dilakukan: migrasi course_classes, class_lecturers, enrollments, class_schedules + service deteksi bentrok + CRUD admin + tampilan dosen/mahasiswa + test bentrok & authorization.
- File PRD yang harus dibaca: DOCS/PRD/00_PETUNJUK_UMUM.txt, 01_MASTER_SPEC.txt, 05_FASE_03_KELAS_ENROLLMENT_JADWAL.txt

---

## Riwayat Fase 1 (2026-10-20, commit 3a65187)
- Enum UserRole (4 role), migrasi role+is_active, middleware role:*, Gates, login/logout/reset, 4 dashboard, seeder demo dev-only.
- Tests: 14/14 lolos, 80 assertions (auth, matriks 16 kombinasi lintas-role, reset password).
- Keputusan: timezone Asia/Jakarta + locale id di config (bukan .env); Livewire ditunda; .env/DB tak diubah.

## Riwayat Fase 0 (2026-10-13, commit 60416b5 + d315849)
- Audit read-only skeleton Laravel 13; PRD DOCS/PRD/ sebagai sumber kebenaran; PRD.txt root usang.

