@extends('layouts.app')

@section('title', 'Dasbor Mahasiswa — MyCampus LMS')

@section('content')
<h1 class="mb-2 text-2xl font-bold">Dasbor Mahasiswa</h1>
<p class="mb-4 text-slate-600">Halo, {{ auth()->user()->name }}. Placeholder Fase 1: kelas terdaftar, jadwal, presensi diri, materi, tugas, dan nilai terpublikasi (Fase 3+).</p>

<div class="grid gap-4 md:grid-cols-3">
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Kelas Saya</h2>
        <p class="text-sm text-slate-600">Kelas yang diikuti (Fase 3).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Tugas</h2>
        <p class="text-sm text-slate-600">Pengumpulan dan deadline (Fase 7).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Nilai</h2>
        <p class="text-sm text-slate-600">Nilai yang sudah dipublikasikan (Fase 7).</p>
    </div>
</div>
@endsection
