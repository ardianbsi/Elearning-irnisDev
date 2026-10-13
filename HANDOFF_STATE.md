# HANDOFF STATE — MyCampus LMS

> AI coding agent: perbarui dokumen ini di akhir setiap fase. Jangan mengklaim pekerjaan selesai tanpa verifikasi.

## Current status
- Fase terakhir: Fase 1 — Fondasi, Autentikasi, Role/Permission, Layout
- Status: In progress (kode selesai, verifikasi test TERTUNDA tooling)
- Tanggal: 2026-10-13
- Branch/commit (jika tersedia): master (commit Fase 1 menyusul)

## Repository baseline
- Laravel: v13.35.0 (syarat composer ^13.17)
- PHP: 8.4.26 CLI ZTS + OPcache (syarat ^8.3 terpenuhi)
- Composer: 2.4.1 (warning deprecation nullable di PHP 8.4, non-blocking)
- Node: v24.21.0
- Database: sqlite aktif (.env), file database/database.sqlite ±98 KB; pgsql tersedia via pdo_pgsql/pgsql tapi belum dikonfigurasi
- UI stack: Tailwind ^4.0.0 + laravel-vite-plugin ^3.1 + vite ^8.0.0; entry resources/css/app.css + resources/js/app.js
- Test framework: PHPUnit ^12.5.12, phpunit.xml sqlite :memory:
- Auth/permission package: belum ada (default session guard web + model User)

## Completed
- [x] Fase 0 — Audit
- [ ] Fase 1 — Fondasi/Auth/UI (kode selesai, test belum terverifikasi via tooling)
- [ ] Fase 2 — Master data
- [ ] Fase 3 — Kelas/Enrollment/Jadwal
- [ ] Fase 4 — Pertemuan/Presensi
- [ ] Fase 5 — Materi
- [ ] Fase 6 — Diskusi
- [ ] Fase 7 — Tugas/Submission/Nilai
- [ ] Fase 8 — Pengumuman/Laporan
- [ ] Fase 9 — Kuliah pengganti
- [ ] Fase 10 — Hardening/Deployment

## Files changed
- HANDOFF_STATE.md: hasil audit Fase 0 + progres Fase 1.
- Fase 1 (baru/diubah):
  - app/Enums/UserRole.php (enum 4 role + label + dashboardRoute)
  - database/migrations/2026_10_13_000001_add_role_to_users_table.php (role + is_active)
  - app/Models/User.php (cast role, helper hasRole/isAdmin)
  - app/Http/Middleware/EnsureRole.php + alias 'role' di bootstrap/app.php
  - app/Http/Requests/Auth/LoginRequest.php
  - app/Http/Controllers/Auth/AuthenticatedSessionController.php (login/logout + tolak nonaktif)
  - app/Http/Controllers/Auth/PasswordResetController.php
  - app/Http/Controllers/DashboardController.php
  - routes/web.php (login/reset/dashboard per role + middleware role)
  - config/app.php (timezone Asia/Jakarta, locale id, faker id_ID)
  - resources/views/layouts/app.blade.php + auth/*.blade.php + dashboard/*.blade.php
  - database/factories/UserFactory.php (default student + state role)
  - database/seeders/DemoUsersSeeder.php (4 akun demo) + DatabaseSeeder (dev-only)
  - tests/Feature/AuthenticationTest.php, RoleAccessTest.php, PasswordResetTest.php

## Database changes
- Migration dibuat: 2026_10_13_000001_add_role_to_users_table (role string 20 default student + index, is_active default true).
- Migration dijalankan pada environment: dev lokal sqlite — Ran batch 2 (terlihat di migrate:status).
- Data seeder: DemoUsersSeeder DONE 1.551 ms di sqlite dev (4 akun demo password).
- Catatan rollback: migrate:rollback satu batch menghapus kolom role/is_active; seeder dev-only, jangan di production.

## Tests
- Command: php artisan test, vendor/bin/phpunit --filter AuthenticationTest, php artisan test > storage/logs/fase1-test.txt
- Hasil aktual: TIDAK TERVERIFIKASI — semua perintah test tidak mengembalikan output ter-capture via tool shell (result kosong/error code 1). File storage/logs/fase1-test.txt kosong.
- Test gagal / tidak dijalankan: AuthenticationTest (5 test), RoleAccessTest (3 test incl. matriks 16 kombinasi), PasswordResetTest (4 test), ExampleTest bawaan.
- Alasan: integrasi shell Windows/Laragon tidak mengembalikan stdout proses test. php -l UserRole OK; migrate:status + db:seed terlihat OK di terminal.

## Decisions
- Sumber kebenaran PRD: DOCS/PRD/ (15 file Fase 0–10); PRD.txt root dianggap usang, diarsipkan nanti.
- Livewire v4 mendukung illuminate ^10|^11|^12|^13 (Packagist 2026-10-07) → DITUNDA. Fase 1 Blade murni karena install dependency utama butuh izin eksplisit (aturan 00 no.5).
- Authorization: Policies/Gates native + enum role (tanpa Spatie), sesuai 01_MASTER_SPEC. Gate::before superadmin + 4 Gate + middleware role:*.
- Timezone Asia/Jakarta + locale id + faker id_ID: DITERAPKAN di config/app.php (bukan .env, sesuai larangan ubah .env).
- .env dan koneksi DB tidak diubah (tetap sqlite dev). PostgreSQL dev menunggu kredensial user.
- Seeder demo dev-only (guard isProduction), password 'password'.

## Known issues / blockers
- Hasil php artisan test BELUM terverifikasi via tooling (output tidak ter-capture). WAJIB: user jalankan `php artisan test` manual di terminal Laragon dan laporkan hasil sebelum Fase 1 dinyatakan Complete.
- File storage/logs/fase1-test.txt kosong (dibuat saat percobaan redirect) — hapus manual atau biarkan, tidak di-commit (storage/logs di-ignore? cek).
- Server PostgreSQL Laragon belum diverifikasi (butuh kredensial/nama DB dari user).
- Lisensi template Matrix Admin belum diverifikasi → dashboard orisinal (keputusan: orisinal, sesuai klausul PRD).
- Reset password memakai MAIL_MAILER=log → tautan hanya di log; diuji via PasswordResetTest dengan token manual.

## Next exact step
- Nama fase berikutnya: Fase 1 (verifikasi) → Fase 2 Master Data
- Prompt/task terkecil yang harus dilakukan: (1) user jalankan php artisan test manual; (2) commit Fase 1; (3) mulai Fase 2.
- File PRD yang harus dibaca: DOCS/PRD/00_PETUNJUK_UMUM.txt, 01_MASTER_SPEC.txt, 04_FASE_02_MASTER_DATA.txt
