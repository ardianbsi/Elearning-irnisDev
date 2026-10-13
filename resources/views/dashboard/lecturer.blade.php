@extends('layouts.app')

@section('title', 'Dasbor Dosen — MyCampus LMS')

@section('content')
<h1 class="mb-2 text-2xl font-bold">Dasbor Dosen</h1>
<p class="mb-4 text-slate-600">Halo, {{ auth()->user()->name }}. Placeholder Fase 1: kelas yang ditugaskan, pertemuan, materi, presensi, tugas, dan penilaian (Fase 3+).</p>

<div class="grid gap-4 md:grid-cols-3">
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Kelas Saya</h2>
        <p class="text-sm text-slate-600">Daftar kelas yang ditugaskan (Fase 3).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Pertemuan & Presensi</h2>
        <p class="text-sm text-slate-600">Kelola sesi dan kehadiran (Fase 4).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Tugas & Nilai</h2>
        <p class="text-sm text-slate-600">Submission dan penilaian (Fase 7).</p>
    </div>
</div>
@endsection
