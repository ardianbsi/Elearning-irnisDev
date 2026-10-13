@extends('layouts.app')

@section('title', 'Dasbor Superadmin — MyCampus LMS')

@section('content')
<h1 class="mb-2 text-2xl font-bold">Dasbor Superadmin</h1>
<p class="mb-4 text-slate-600">Halo, {{ auth()->user()->name }}. Placeholder Fase 1: konfigurasi, akun, role/permission, dan audit (dibangun di fase berikutnya).</p>

<div class="grid gap-4 md:grid-cols-3">
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Konfigurasi</h2>
        <p class="text-sm text-slate-600">Pengaturan institusi (Fase berikutnya).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Akun & Role</h2>
        <p class="text-sm text-slate-600">Kelola pengguna dan hak akses (Fase berikutnya).</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
        <h2 class="font-semibold">Audit</h2>
        <p class="text-sm text-slate-600">Jejak perubahan sensitif (Fase berikutnya).</p>
    </div>
</div>
@endsection
