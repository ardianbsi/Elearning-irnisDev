@extends('layouts.app')

@section('title', 'Dasbor Admin Akademik — MyCampus LMS')

@section('content')
<h1 class="mb-2 text-2xl font-bold">Dasbor Admin Akademik</h1>
<p class="mb-4 text-slate-600">Halo, {{ auth()->user()->name }}. Placeholder Fase 1: master akademik, kelas, jadwal, enrollment, dan laporan (Fase 2+).</p>

<div class="grid gap-4 md:grid-cols-3">
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Master Akademik</h2>
        <p class="text-sm text-slate-600">Fakultas, prodi, semester, matkul, ruang (Fase 2).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Kelas & Jadwal</h2>
        <p class="text-sm text-slate-600">Kelas, dosen pengampu, enrollment (Fase 3).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Laporan</h2>
        <p class="text-sm text-slate-600">Rekap akademik dan export CSV (Fase 8).</p>
    </div>
</div>
@endsection
