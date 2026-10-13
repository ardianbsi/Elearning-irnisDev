# HANDOFF STATE — MyCampus LMS

> AI coding agent: perbarui dokumen ini di akhir setiap fase. Jangan mengklaim pekerjaan selesai tanpa verifikasi.

## Current status
- Fase terakhir: Fase 0 — Audit Repository
- Status: Complete
- Tanggal: 2026-10-13
- Branch/commit (jika tersedia): master (initial commit menyusul)

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
- [ ] Fase 1 — Fondasi/Auth/UI
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
- HANDOFF_STATE.md (baru): hasil audit Fase 0.
- Tidak ada perubahan kode aplikasi pada Fase 0.

## Database changes
- Migration dibuat: tidak ada.
- Migration dijalankan pada environment: tidak ada.
- Data seeder: tidak ada.
- Catatan rollback: tidak perlu.

## Tests
- Command: php artisan test (tidak mengembalikan output ter-capture via tool shell)
- Hasil aktual: BELUM TERVERIFIKASI — output tool kosong, jangan dianggap lulus.
- Test gagal / tidak dijalankan: full suite belum terkonfirmasi; hanya ada tests/Feature/ExampleTest + tests/Unit/ExampleTest bawaan.
- Alasan: integrasi shell Windows/Laragon tidak mengembalikan stdout perintah artisan.

## Decisions
- Sumber kebenaran PRD: DOCS/PRD/ (15 file Fase 0–10); PRD.txt root dianggap usang, diarsipkan nanti.
- Livewire v4 mendukung illuminate ^10|^11|^12|^13 (Packagist 2026-10-07) → kandidat UI Fase 1, instalasi via composer resmi saat Fase 1.
- Authorization: Policies/Gates native + kolom/enum role (tanpa Spatie), sesuai 01_MASTER_SPEC.
- Timezone Asia/Jakarta + locale id: diusulkan untuk Fase 1 (menunggu persetujuan, menyentuh config).
- Menunggu persetujuan: nama DB/user PostgreSQL dev; .env produksi tidak diubah tanpa izin.

## Known issues / blockers
- php artisan test belum terkonfirmasi (output tidak ter-capture).
- composer -V / node -v terlihat di terminal tapi result tool error; versi dicatat dari konten terminal.
- git init sudah jalan (branch master, untracked files terlihat) tapi commit belum dibuat.
- Server PostgreSQL Laragon belum diverifikasi (butuh kredensial/nama DB dari user).
- Lisensi template Matrix Admin belum diverifikasi → default dashboard orisinal.

## Next exact step
- Nama fase berikutnya: Fase 1 — Fondasi, Autentikasi, Role/Permission, Layout
- Prompt/task terkecil yang harus dilakukan: verifikasi composer/node/pgsql + baseline test, lalu buat HANDOFF commit Fase 0.
- File PRD yang harus dibaca: DOCS/PRD/00_PETUNJUK_UMUM.txt, 01_MASTER_SPEC.txt, 03_FASE_01_FONDASI_AUTH_UI.txt
